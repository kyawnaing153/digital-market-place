<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Frontend\{ProductCategory, ProductSubCategory, Product, Page, Testimonial, Wishlist, HomeContent};
use App\Models\{Order, OrderProduct, Country, VendorRequest};
use Auth, Session, Redirect, DB;
use Carbon\Carbon;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Artisan;
use App\Models\User;

class HomeViewController extends Controller
{
	/**
	 * Home index Page.
	 */
	public function index()
	{
		if (!config('services.APP_INSTALL')) {
			return redirect()->route('frontend.install');
		}
		$user = Auth::user();
		$data['setting'] = getSetting(); //get setting

		//get featured category
		$data['featured_category'] = ProductCategory::where(['is_featured' => 1, 'is_active' => 1])->get();
		//get random order products
		$data['products'] = Product::where(['is_active' => 1])->whereNotNull('published_at')->inRandomOrder()->take(12)->get();
		//get featured order products
		$data['featured_products'] = Product::where(['is_featured' => 1, 'is_active' => 1])->whereNotNull('published_at')->inRandomOrder()->take(6)->get();
		$data['testimonials'] = Testimonial::inRandomOrder()->where(['is_active' => 1])->take(5)->get();

		$home_section = new HomeContent(); //for home content
		$data['why_choose_us'] = $home_section->where(['is_active' => 1, 'type' => 'WhyChooseSection'])->get();
		$data['start_section'] = $home_section->where(['is_active' => 1, 'type' => 'StartSection'])->get();
		return view('frontend.home.home', $data);
	}

	/* user login page */
	public function login_view()
	{
		return view('frontend.login');
	}

	/* user registration page */
	public function register_view()
	{
		return view('frontend.register');
	}

	/* user forgot password page */
	public function forgot_view()
	{
		return view('frontend.forgot-password');
	}

	/* user reset password page */
	public function reset_password_view(request $request)
	{
		$data['token'] = $request->token;
		return view('frontend.reset-password', $data);
	}

	/* about us page */
	public function aboutus_view()
	{
		$data['data'] = Page::where('slug', 'about-us')->first();
		return view('frontend.footer-pages.common-page', $data);
	}
	/* privacy policy page */
	public function privacy_policy_view()
	{
		$data['data'] = Page::where('slug', 'privacy-policy')->first();
		return view('frontend.footer-pages.common-page', $data);
	}
	/* terms and conditions page */
	public function terms_and_conditions_view()
	{
		$data['data'] = Page::where('slug', 'terms-and-conditions')->first();
		return view('frontend.footer-pages.common-page', $data);
	}

	/* author terms and conditions page */
	public function author_terms_and_conditions_view()
	{
		$data['data'] = Page::where('slug', 'author-terms-and-conditions')->first();
		return view('frontend.footer-pages.common-page', $data);
	}


	/* contactus page */
	public function contactus_view()
	{
		return view('frontend.footer-pages.contact-us');
	}

	/* user my profile page */
	public function profile_view()
	{
		$user = Auth::user();
		$data['user'] = $user;
		$data['country'] = Country::orderBy('name', 'ASC')->get();
		$data['vendor_request'] = VendorRequest::where('user_id', $user->id)->first();
		if ($user->role == 2) { // vendor sees customers who requested them
			$chatUsers = User::whereIn('id', function ($q) use ($user) {
				$q->select('customer_id')->from('chat_requests')->where('vendor_id', $user->id);
			})->orderByDesc('id')->get();
			$type = 'customer';
		} elseif ($user->role == 1) { // customer sees all vendors
			$chatUsers = User::where('role', 2)->orderByDesc('id')->get();
			$type = 'vendor';
		} else {
			$chatUsers = User::whereIn('role', [1, 2])->orderByDesc('id')->get();
			$type = 'all';
		}
		 // Set active user ID (first in list, or null if empty)
    	$activeUserId = request('chat') ?? $chatUsers->first()->id ?? null;

		return view('frontend.user.profile', $data, compact('chatUsers', 'type', 'activeUserId'));
	}
	/* user my wishlist page */
	public function wishlist_view()
	{
		$data['product_items'] = Product::where(['is_active' => 1])->whereNotNull('published_at')->mightAlsoLike()->get();
		$data['wishlist'] = Wishlist::where('user_id', Auth::id())->get();
		return view('frontend.cart.wishlist', $data);
	}


	public function install()
	{
		DotenvEditor::setKey('APP_URL', url('/'));

		if (request()->getHost() === 'localhost') {
			$ASSET_URL = url('/') . '/public';
		} else {
			$ASSET_URL = url('/');
		}

		DotenvEditor::setKey('ASSET_URL', $ASSET_URL);
		DotenvEditor::setKey('APP_DEBUG', 'false');
		DotenvEditor::setKey('APP_INSTALL', 'true');
		DotenvEditor::setKey('APP_ENV', 'production');
		DotenvEditor::save();

		Artisan::call('key:generate', ['--force' => true]);
		Artisan::call('storage:link');
		Artisan::call('view:clear');
		Artisan::call('config:clear');
		Artisan::call('cache:clear');
		Artisan::call('route:clear');

		return redirect()->route('frontend.home', app()->getLocale());
	}
}
