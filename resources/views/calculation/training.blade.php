@extends('layouts.template')

@section('breadcrumb')
    <h3 class="animated fadeInLeft">Data Training</h3>
@endsection

@section('content')

<style>
    .aktual{
        -webkit-transform:rotate(-90deg);
        -moz-transform: rotate(-90deg);
        text-align: center;
    }
</style>
@if(Session::has('message'))
<div class="col-md-12">
    <div class="alert alert-success alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
      {{ Session::get('message') }}
    </div>
</div>
    @php
        Session::forget('message');
    @endphp
@endif

<div class="col-md-12 tabs-area">
    <ul id="tabs-demo4" class="nav nav-tabs nav-tabs-v3" role="tablist">
     <li role="presentation" class="active">
       <a href="#tabs-demo4-area1" id="tabs-demo4-1" role="tab" data-toggle="tab" aria-expanded="true">LVQ 1</a>
     </li>
     <li role="presentation" class="">
       <a href="#tabs-demo4-area2" role="tab" id="tabs-demo4-2" data-toggle="tab" aria-expanded="false">LVQ 2.1</a>
     </li>
     <li role="presentation">
       <a href="#tabs-demo4-area3" id="tabs-demo4-3" role="tab" data-toggle="tab" aria-expanded="false">LVQ 3</a>
     </li>
   </ul>
   <div id="tabsDemo4Content" class="tab-content tab-content-v3">
     <div role="tabpanel" class="tab-pane fade active in col-12" id="tabs-demo4-area1" aria-labelledby="tabs-demo4-area1">
        <div class="col-md-12 panel-body" style="padding-bottom:30px;">
            <div class="col-md-12">
                <form class="cmxform" action="{{route('lvq1')}}" method="POST" id="lvq1" novalidate="novalidate">
                    @csrf
                    <input type="hidden" name="type1" value="1">
                    <input type="hidden" name="window1" value="0">
                    <div class="col-md-6">
                        <div class="form-group form-animate-text" style="margin-top:40px !important;">
                            <input type="text" value="{{$lvq1->alpha}}" onkeypress="return err(this)" class="form-text" id="alpha1" name="alpha1" required="" aria-required="true">
                            <span class="bar"></span>
                            <label>Alpha</label>
                        </div>
                        <div class="form-group form-animate-text" style="margin-top:40px !important;">
                            <input type="text" value="{{$lvq1->decAlpha}}" onkeypress="return err(this)" class="form-text" id="decAlpha1" name="decAlpha1" required="" aria-required="true">
                            <span class="bar"></span>
                            <label>Pengurangan Alpha</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-animate-text" style="margin-top:40px !important;">
                            <input type="text" value="{{$lvq1->minAlpha}}" onkeypress="return err(this)" class="form-text" id="minAlpha1" name="minAlpha1" required="" aria-required="true">
                            <span class="bar"></span>
                            <label>Minimum Alpha</label>
                        </div>
                        <div class="form-group form-animate-text" style="margin-top:40px !important;">
                            <input type="text" value="{{$lvq1->maxEpoch}}" onkeypress="return err(this)" class="form-text" id="maxEpoch1" name="maxEpoch1" required="" aria-required="true">
                            <span class="bar"></span>
                            <label>Max Epoch</label>
                        </div>
                    </div>                   
                    <div class="col-md-2 pull-right">
                        <button type="submit" class="btn ripple btn-gradient btn-info">
                            <div>
                              <span>Train</span>
                            <span class="ink animate" style="height: 506px; width: 506px; top: -240px; left: 18px;"></span></div>
                        </button>
                  </div>
                </form>
            </div>
            <div class="clearfix"></div>
        @if ($acc1->count() > 0)
            <div style="margin-top: 40px;" class="col-md-6">
                <h4>Bobot Akhir Hasil Algoritma LVQ 1</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                @foreach ($res1 as $key => $data)
                                <th>Target {{$key+1}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            @foreach ($res1 as $key => $data)  
                                <td>
                                    <ul>
                                @foreach ($data as $value => $item)
                                   <li>X{{$value+1}} = {{round($item,6)}}</li>
                                 @endforeach
                                </ul>
                                </td>
                            @endforeach
                        </tr>
                        </tbody> 
                    </table>
                </div>
            </div>
            <div style="margin-top: 40px;" class="col-md-4">
                <h4>Confusion Matrix</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th rowspan="{{count(json_decode($acc1->confusion_matrix))}}" colspan="{{count(json_decode($acc1->confusion_matrix))}}" style="background-color:rgb(0, 132, 255)"></th>
                            <th colspan="{{count(json_decode($acc1->confusion_matrix))}}" style="text-align: center;">Prediksi</th>
                        </tr>
                        <tr>
                            @foreach (json_decode($acc1->confusion_matrix) as $key => $item)
                                <th>Target {{$key+1}}</th>
                            @endforeach
                        </tr>
                        <tr>
                            <th class="aktual" rowspan="{{count(json_decode($acc1->confusion_matrix))+1}}">Aktual</th>
                        </tr>
                        @foreach (json_decode($acc1->confusion_matrix) as $key => $item)
                                <tr>
                                    <th>Target {{$key+1}}</th>
                                    @foreach ($item as $value)
                                        <th>{{$value}}</th>
                                    @endforeach
                                </tr>
                        @endforeach   
                    </table>
                </div>
                <h4>Report</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Jenis</th>
                            @foreach ($res1 as $key => $data)
                            <th>Target {{$key+1}}</th>
                            @endforeach
                        </tr>
                        <tr>
                            @php
                                $data = collect(json_decode($acc1->classification_report))->toArray();
                            @endphp
                            @foreach ($data as $key => $item)
                                <tr>
                                    <th>{{ucwords($key)}}</th>
                                    @foreach ($item as $value)
                                    @if ($key != 'support')
                                    @endif
                                        <th>{{round($value,5)}}</th>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tr>
                    </table>
                </div>
            </div>
            <div style="margin-top: 40px;" class="col-md-2">
                <h4>Akurasi {{round($acc1->acuracy,5)}}%</h4>
            </div>
        @endif
        </div>
     </div>
     <div role="tabpanel" class="tab-pane fade" id="tabs-demo4-area2" aria-labelledby="tabs-demo4-area2">
        <div class="col-md-12 panel-body" style="padding-bottom:30px;">
            <div class="col-md-12">
                <form class="cmxform" action="{{route('lvq2')}}" method="POST" id="lvq2" novalidate="novalidate">
                    @csrf
                    <input type="hidden" name="type2" value="2">
                    <div class="col-md-6">
                        <div class="form-group form-animate-text" style="margin-top:40px !important;">
                            <input type="text" value="{{$lvq2->alpha}}" onkeypress="return err(this)" class="form-text" id="alpha2" name="alpha2" required="" aria-required="true">
                            <span class="bar"></span>
                            <label>Alpha</label>
                        </div>
                        <div class="form-group form-animate-text" style="margin-top:40px !important;">
                            <input type="text" value="{{$lvq2->decAlpha}}" onkeypress="return err(this)" class="form-text" id="decAlpha2" name="decAlpha2" required="" aria-required="true">
                            <span class="bar"></span>
                            <label>Pengurangan Alpha</label>
                        </div>
                        <div class="form-group form-animate-text" style="margin-top:40px !important;">
                            <input type="text" value="{{$lvq2->window}}" onkeypress="return err(this)" class="form-text" id="window2" name="window2" required="" aria-required="true">
                            <span class="bar"></span>
                            <label>Window</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-animate-text" style="margin-top:40px !important;">
                            <input type="text" value="{{$lvq2->minAlpha}}" onkeypress="return err(this)" class="form-text" id="minAlpha2" name="minAlpha2" required="" aria-required="true">
                            <span class="bar"></span>
                            <label>Minimum Alpha</label>
                        </div>
                        <div class="form-group form-animate-text" style="margin-top:40px !important;">
                            <input type="text" value="{{$lvq2->maxEpoch}}" onkeypress="return err(this)" class="form-text" id="maxEpoch2" name="maxEpoch2" required="" aria-required="true">
                            <span class="bar"></span>
                            <label>Max Epoch</label>
                        </div>
                    </div>                   
                    <div class="col-md-2 pull-right">
                        <button type="submit" class="btn ripple btn-gradient btn-info">
                            <div>
                              <span>Train</span>
                            <span class="ink animate" style="height: 506px; width: 506px; top: -240px; left: 18px;"></span></div>
                        </button>
                  </div>
                </form>
            </div>
            <div class="clearfix"></div>
        @if ($acc2->count() > 0)
            <div style="margin-top: 40px;" class="col-md-6">
                <h4>Bobot Akhir Hasil Algoritma LVQ 2.1</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                @foreach ($res2 as $key => $data)
                                <th>Target {{$key+1}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            @foreach ($res2 as $key => $data)  
                                <td>
                                    <ul>
                                @foreach ($data as $value => $item)
                                   <li>X{{$value+1}} = {{round($item,6)}}</li>
                                 @endforeach
                                </ul>
                                </td>
                            @endforeach
                        </tr>
                        </tbody> 
                    </table>
                </div>
            </div>
            <div style="margin-top: 40px;" class="col-md-4">
                <h4>Confusion Matrix</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th rowspan="{{count(json_decode($acc2->confusion_matrix))}}" colspan="{{count(json_decode($acc2->confusion_matrix))}}" style="background-color:rgb(0, 132, 255)"></th>
                            <th colspan="{{count(json_decode($acc2->confusion_matrix))}}" style="text-align: center;">Prediksi</th>
                        </tr>
                        <tr>
                            @foreach (json_decode($acc2->confusion_matrix) as $key => $item)
                                <th>Target {{$key+1}}</th>
                            @endforeach
                        </tr>
                        <tr>
                            <th class="aktual" rowspan="{{count(json_decode($acc2->confusion_matrix))+1}}">Aktual</th>
                        </tr>
                        @foreach (json_decode($acc2->confusion_matrix) as $key => $item)
                                <tr>
                                    <th>Target {{$key+1}}</th>
                                    @foreach ($item as $value)
                                        <th>{{$value}}</th>
                                    @endforeach
                                </tr>
                        @endforeach   
                    </table>
                </div>
                <h4>Report</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Jenis</th>
                            @foreach ($res2 as $key => $data)
                            <th>Target {{$key+1}}</th>
                            @endforeach
                        </tr>
                        <tr>
                            @php
                                $data = collect(json_decode($acc2->classification_report))->toArray();
                            @endphp
                            @foreach ($data as $key => $item)
                                <tr>
                                    <th>{{ucwords($key)}}</th>
                                    @foreach ($item as $value)
                                    @if ($key != 'support')
                                    @endif
                                        <th>{{round($value,5)}}</th>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tr>
                    </table>
                </div>
            </div>
            <div style="margin-top: 40px;" class="col-md-2">
                <h4>Akurasi {{round($acc2->acuracy,5)}}%</h4>
            </div>  
        @endif
        </div>
     </div>
     <div role="tabpanel" class="tab-pane fade" id="tabs-demo4-area3" aria-labelledby="tabs-demo4-area3">
        <div class="col-md-12 panel-body" style="padding-bottom:30px;">
            <div class="col-md-12">
                <form class="cmxform" action="{{route('lvq3')}}" method="POST" id="lvq3" novalidate="novalidate">
                    @csrf
                    <input type="hidden" name="type3" value="3">
                    <div class="col-md-6">
                        <div class="form-group form-animate-text" style="margin-top:40px !important;">
                            <input type="text" value="{{$lvq3->alpha}}" onkeypress="return err(this)" class="form-text" id="alpha3" name="alpha3" required="" aria-required="true">
                            <span class="bar"></span>
                            <label>Alpha</label>
                        </div>
                        <div class="form-group form-animate-text" style="margin-top:40px !important;">
                            <input type="text" value="{{$lvq3->decAlpha}}" onkeypress="return err(this)" class="form-text" id="decAlpha3" name="decAlpha3" required="" aria-required="true">
                            <span class="bar"></span>
                            <label>Pengurangan Alpha</label>
                        </div>
                        <div class="form-group form-animate-text" style="margin-top:40px !important;">
                            <input type="text" value="{{$lvq3->window}}" onkeypress="return err(this)" class="form-text" id="window3" name="window3" required="" aria-required="true">
                            <span class="bar"></span>
                            <label>Window</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-animate-text" style="margin-top:40px !important;">
                            <input type="text" value="{{$lvq3->minAlpha}}" onkeypress="return err(this)" class="form-text" id="minAlpha3" name="minAlpha3" required="" aria-required="true">
                            <span class="bar"></span>
                            <label>Minimum Alpha</label>
                        </div>
                        <div class="form-group form-animate-text" style="margin-top:40px !important;">
                            <input type="text" value="{{$lvq3->maxEpoch}}" onkeypress="return err(this)" class="form-text" id="maxEpoch3" name="maxEpoch3" required="" aria-required="true">
                            <span class="bar"></span>
                            <label>Max Epoch</label>
                        </div>
                    </div>                   
                    <div class="col-md-2 pull-right">
                        <button type="submit" class="btn ripple btn-gradient btn-info">
                            <div>
                              <span>Train</span>
                            <span class="ink animate" style="height: 506px; width: 506px; top: -240px; left: 18px;"></span></div>
                        </button>
                  </div>
                </form>
            </div>
            <div class="clearfix"></div>
        @if ($acc3->count() > 0)
            <div style="margin-top: 40px;" class="col-md-6">
                <h4>Bobot Akhir Hasil Algoritma LVQ 3</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                @foreach ($res3 as $key => $data)
                                <th>Target {{$key+1}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            @foreach ($res3 as $key => $data)  
                                <td>
                                    <ul>
                                @foreach ($data as $value => $item)
                                   <li>X{{$value+1}} = {{round($item,6)}}</li>
                                 @endforeach
                                </ul>
                                </td>
                            @endforeach
                        </tr>
                        </tbody> 
                    </table>
                </div>
            </div>
            <div style="margin-top: 40px;" class="col-md-4">
                <h4>Confusion Matrix</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th rowspan="{{count(json_decode($acc3->confusion_matrix))}}" colspan="{{count(json_decode($acc3->confusion_matrix))}}" style="background-color:rgb(0, 132, 255)"></th>
                            <th colspan="{{count(json_decode($acc3->confusion_matrix))}}" style="text-align: center;">Prediksi</th>
                        </tr>
                        <tr>
                            @foreach (json_decode($acc3->confusion_matrix) as $key => $item)
                                <th>Target {{$key+1}}</th>
                            @endforeach
                        </tr>
                        <tr>
                            <th class="aktual" rowspan="{{count(json_decode($acc3->confusion_matrix))+1}}">Aktual</th>
                        </tr>
                        @foreach (json_decode($acc3->confusion_matrix) as $key => $item)
                                <tr>
                                    <th>Target {{$key+1}}</th>
                                    @foreach ($item as $value)
                                        <th>{{$value}}</th>
                                    @endforeach
                                </tr>
                        @endforeach   
                    </table>
                </div>
                <h4>Report</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Jenis</th>
                            @foreach ($res3 as $key => $data)
                            <th>Target {{$key+1}}</th>
                            @endforeach
                        </tr>
                        <tr>
                            @php
                                $data = collect(json_decode($acc3->classification_report))->toArray();
                            @endphp
                            @foreach ($data as $key => $item)
                                <tr>
                                    <th>{{ucwords($key)}}</th>
                                    @foreach ($item as $value)
                                    @if ($key != 'support')
                                    @endif
                                        <th>{{round($value,5)}}</th>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tr>
                    </table>
                </div>
            </div>
            <div style="margin-top: 40px;" class="col-md-2">
                <h4>Akurasi {{round($acc3->acuracy,5)}}%</h4>
            </div>  
        @endif
        </div>
     </div>
   </div>
 </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function(){
            $("#lvq1").validate({
                errorElement: "em",
                errorPlacement: function(error, element) {
                    $(element.parent("div").addClass("form-animate-error"));
                    error.appendTo(element.parent("div"));
                },
                success: function(label) {
                    $(label.parent("div").removeClass("form-animate-error"));
                },
                rules: {
                    alpha1: "required",
                    decAlpha1: "required",
                    minAlpha1:"required",
                    maxEpoch1: "required",
                },
                messages: {
                    alpha1: "Alpha wajib diisi",
                    decAlpha1: "Pengurangan alpha wajib diisi",
                    minAlpha1: "Minimum alpha wajib diisi",
                    maxEpoch1: "Max Epoch wajib diisi",
                }
            });
            $("#lvq2").validate({
                errorElement: "em",
                errorPlacement: function(error, element) {
                    $(element.parent("div").addClass("form-animate-error"));
                    error.appendTo(element.parent("div"));
                },
                success: function(label) {
                    $(label.parent("div").removeClass("form-animate-error"));
                },
                rules: {
                    alpha2: "required",
                    decAlpha2: "required",
                    minAlpha2:"required",
                    maxEpoch2: "required",
                    window2: "required"
                },
                messages: {
                    alpha2: "Alpha wajib diisi",
                    decAlpha2: "Pengurangan alpha wajib diisi",
                    minAlpha2: "Minimum alpha wajib diisi",
                    maxEpoch2: "Max Epoch wajib diisi",
                    window2: "Window wajib diisi"
                }
            });
            $("#lvq3").validate({
                errorElement: "em",
                errorPlacement: function(error, element) {
                    $(element.parent("div").addClass("form-animate-error"));
                    error.appendTo(element.parent("div"));
                },
                success: function(label) {
                    $(label.parent("div").removeClass("form-animate-error"));
                },
                rules: {
                    alpha3: "required",
                    decAlpha3: "required",
                    minAlpha3:"required",
                    maxEpoch3: "required",
                    window3: "required"
                },
                messages: {
                    alpha3: "Alpha wajib diisi",
                    decAlpha3: "Pengurangan alpha wajib diisi",
                    minAlpha3: "Minimum alpha wajib diisi",
                    maxEpoch3: "Max Epoch wajib diisi",
                    window3: "Window wajib diisi"
                }
            });
        });
    </script>
@endsection 