<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\{Languages};
use Lang;
use Validator,File;
use Illuminate\Validation\Rule;
class LocaleFileController extends Controller
{
    private $lang = '';
    private $file = 'master';
    private $key1 = '';
    private $key2 = '';
    private $value;
    private $path;
    private $arrayLang = array();

    public function __construct(Type $var = null) {
        if ($this->lang == '')
        $this->lang = App::getLocale();
        $this->path = base_path().'/resources/lang/'.$this->lang.'/'.$this->file.'.php';
        $this->arrayLang = Lang::get($this->file);
    }

   /*  update master file content */
    public function store_master_file(request $request)
    {
        $request->request->remove('_token'); 
        $lang = $request->lang;
        $request->request->remove('lang'); 
        $input = $request->all();

        $content = "<?php\n\nreturn\n[\n";
        foreach ($input as $key => $value) 
        {

            $content .= "\t'".$key."' => \n[\n";
            foreach ($value as $key2 => $value2) {

                $content .= "\t'".$key2."' => ".'"'.$value2.'"'.",\n";
            }
            $content .= "],";
        }
        $content .= "];";

        $path = base_path().'/resources/lang/'.$lang.'/master.php';
        file_put_contents($path, $content);
        return response()->json(['status' => true,'msg' =>trans('msg.lang_file_update')], 200);       

    }

    /*  update master file content */
    public function store_page_title_file(request $request)
    {
        $request->request->remove('_token'); 
        $lang = $request->lang;
        $request->request->remove('lang'); 
        $input = $request->all();

        $content = "<?php\n\nreturn\n[\n";
        foreach ($input as $key => $value) 
        {

            $content .= "\t'".$key."' => \n[\n";
            foreach ($value as $key2 => $value2) {

                $content .= "\t'".$key2."' => ".'"'.$value2.'"'.",\n";
            }
            $content .= "],";
        }
        $content .= "];";

        $path = base_path().'/resources/lang/'.$lang.'/page_title.php';
        file_put_contents($path, $content);
        return response()->json(['status' => true,'msg' =>trans('msg.lang_file_update')], 200);       

    }

    /* update admin message file content */
    public function store_message_file(request $request)
    {
        $request->request->remove('_token'); 
        $lang = $request->lang;
        $request->request->remove('lang');
        $input = $request->all();

        $content = "<?php\n\nreturn\n[\n";
        foreach ($input as $key => $value) 
        {
            $content .= "\t'".$key."' => ".'"'.$value.'"'.",\n";
        }
        $content .= "];";

        $path = base_path().'/resources/lang/'.$lang.'/msg.php';
        file_put_contents($path, $content);
        return response()->json(['status' => true,'msg' =>trans('msg.lang_file_update')], 200);
    }

    /*  update frontend message file content */
    public function store_fnt_message_file(request $request)
    {
        $request->request->remove('_token'); 
        $lang = $request->lang;
        $request->request->remove('lang');
        $input = $request->all();

        $content = "<?php\n\nreturn\n[\n";
        foreach ($input as $key => $value) 
        {
            $content .= "\t'".$key."' => ".'"'.$value.'"'.",\n";
        }
        $content .= "];";

        $path = base_path().'/resources/lang/'.$lang.'/frontend_msg.php';
        file_put_contents($path, $content);
        return response()->json(['status' => true,'msg' =>trans('msg.lang_file_update')], 200);
    }

    /* Show all language file list */
    public function show($lang)
    {
        $this->lang = $lang;
        App::setLocale($lang);
        $this->path = base_path().'/resources/lang/'.$this->lang.'/'.$this->file.'.php';
        $data['lang'] = $lang;
        $data['master'] = Lang::get('master');
        $data['message'] = Lang::get("msg");
        $data['fnt_message'] = Lang::get("frontend_msg");
        $data['page_title'] = Lang::get("page_title");
        return view('admin.lang.show',$data);
    }

    /* get all language */
    public function index(Request $request)
    {
        $data = Languages::all();
        return view('admin.lang.index',compact('data'));
    }
    /**
     * Store a newly created Page in storage.
     */
    public function store(Request $request)
    {
        $rules['name'] = ['required',Rule::unique('languages')->where(function($query) use($request){
            $query->where('id', '!=', @$request->id);
        })];
        $rules['short_name'] = 'required';

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'msg' => $validator->messages()->first()], 400);
        
        $obj = Languages::firstOrNew(['id'=>@$request->id]);
        $obj->name = strtolower($request->name);
        $obj->short_name = strtolower($request->short_name);
        $obj->save();

        $path = base_path().'/resources/lang/'.strtolower($request->short_name);
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }   
        $msg = (isset($request->id) && !empty($request->id))? trans('msg.lang_update') : trans('msg.lang_added');
        return response()->json(['status' => true,'msg' =>$msg,'url'=>route('admin.lang.index')], 200);
    }
     /**
     * Show the form for creating a new resource.
     */

     public function create(){
       return view('admin.lang.create_or_edit');
     }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Languages::find($id);
        if(empty($data)){
          return redirect()->route('admin.lang.index');
        }
        return view('admin.lang.create_or_edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $obj = Languages::find($id);
        if($obj->is_active == 1){
            $obj->is_active = 0;
            $msg = trans('msg.de_active');
        }
        else{
            $obj->is_active = 1;
            $msg = trans('msg.active');
        }
        $obj->save();
        return response()->json(['status' => true,'msg' =>$msg], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
     public function destroy(string $id)
     {
         $data = Languages::find($id);
         $data->delete();
         return response()->json(['status' => true,'msg' =>trans('msg.lang_del')], 200);       
     }
}
