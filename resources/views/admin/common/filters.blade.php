  <!--===Common Filter Section Start===-->
<form action="">
    <div class="row align-items-center">
        <div class="row mt-2">
            <div class="col-lg-2">
                <div class="tp_form_wrapper">
                    <div class="tp_custom_select">
                        <select class="form-control" name="key">
                            <option selected value="">Key</option>
                        
                            @foreach ($searchable as $key => $val)
                                <option value="{{ $key }}" @if (request('key') == $key) selected @endif>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="tp_form_wrapper">
                    <div class="tp_custom_select">
                        <select class="form-control" name="filter">
                            <option selected value="">Filter</option>
                            @php
                                $filter = [
                                    'contains' => 'Contains',
                                    'equals' => 'Equals to',
                                    'greaterEquals' => 'Greater or Equals to',
                                    'lesserEquals' => 'Lesser or Equals to',
                            ]; @endphp
                            @foreach ($filter as $key => $val)
                                <option value="{{ $key }}" @if (request('filter') == $key) selected @endif>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="tp_form_wrapper tp_pro_search">
                    <input type="text" class="form-control" placeholder="Search here..." name="s"
                        value="{{ request('s') }}">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="tp_prosearch_btn">
                    <button type="submit" class="tp_btn">search</button>
                    <a href="{{ Request::url() }}" class="tp_btn"><i class="fa fa-refresh"></i></a>
                </div>
            </div>
        </div>
    </div>
</form>
  <!--===Section End===-->