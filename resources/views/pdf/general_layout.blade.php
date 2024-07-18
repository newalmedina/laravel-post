<html>
<head>
<style>
 @font-face {
    font-family: 'imperialscriptsec';
    src: url({{ storage_path('fonts\imperialscriptsec.ttf') }}) format("truetype");
}
/** Define the margins of your page **/
    @page {
    margin: 80px 80px;
    page-break-inside: avoid;
    }
   
    header {
        position: relative;
        top: -60px;
        left: 0px;
        right: 0px;
        height: 50px;

    }

    footer {
        position: fixed;
        bottom: -60px;
        left: 0px;
        right: 0px;
        height: 50px;

        /** Extra personal styles **/
        font-size: 8px;
    }
    .logo{
        position:relative;
        top:0px;
        margin-bottom:-100px;
    }
    .clearfix::after {
        content: "";
        display: table;
        clear: both;
    }
    .bordered-table {

        margin-top: 30px;
    border-collapse: collapse;
    width: 100%;
    }

    .bordered-table th,
    .bordered-table td {
    border: 1px solid black;
    padding: 2px;
    text-align: left;
    }

    .bordered-table th {
    background-color: #f2f2f2;
    text-align: center;
    }
    .table-text {
            font-size: 13px;
        }
        .page:after {
            content: counter(page);
        }
        .doctor-name {
            /* font-family: 'imperialscript'; */
            font-weight: 400; // use the matching font-weight here ( 100, 200, 300, 400, etc).
            
        }   
</style>
</head>
<body>
    @php
    $setting =\App\Services\SettingsServices::getGeneral();
    $center = \App\Models\Center::find($doctorInfo->hasSelectedCenter());
    

    @endphp
<!-- Define header and footer blocks before your content -->
    <header>
       <div class="logo">
            <div style="width:100px; height:80px;" >
                @if(!empty($setting->image))
                     {{-- <img src='{{ url(' admin/settings/get-image/'.$setting->image) }}' class="" alt="Porto Admin" style="width:100%"> --}}
                    <img style="width:100%; height:100%; border-top: 2px solid black;" src="{{ asset('settings/'.$setting->image)}}" alt="{{ $setting->site_name }}" style="width:100%; height:100%; object-fit: fill;">
                @else
                    <img src="{{ asset('assets/admin/img/logo.png')}}" alt="Porto Admin" style="width:100%; height:100%; object-fit: fill;">
                @endif
            </div>
           
       </div>
      <div style="text-align: center; margin-bottom:5px;">
         <div>
         <h2>{{ $setting->site_name }} </h2>
                    <h3 class=""style="margin-top: -15px;">{{ $center->name }}</h3>
                    <p style="font-size: 9px; margin-top: -15px;">
                            {{ $center->fullAddress }} <br>
                        <i>Tel:</i> {{ $center->phone }} <br>
                        <i>Email:</i> {{ $center->email }} <
                    </p>
                    <i>{{ $date }}</i>
         </div>
        <label class='text-primary' class="doctor-name" style="font-size:50px;">
            {{ $doctorInfo->userProfile->fullName }}
         
        </label>
      </div>
      
    </header>

    <footer>
        <p  >
            {{ $setting->site_name }}. 
            {{ $setting->complete_address }},
             <i>tel:</i>{{ $setting->phone }}, 
            <i>email: </i>{{ $setting->email }}
        </p>
        <p class="page" style="text-align: right">
            Página
        </p>
    </footer>

    <!-- Wrap the content of your PDF inside a main tag -->
    <main style="padding-top:100px;">
        <table class="bordered-table">
            <tr>
                <th colspan="">
                    {{ $title }}
                   
                </th>
            </tr>
        </table>

        <table class="bordered-table">
            <tr>
                <th colspan="4">{{ $doctor_info}}</th>
            </tr>
            <tr class="table-text">
                <td><b>{{ trans("pdfLayout/admin_lang.exequatur") }}</b>: {{ !empty($doctorInfo->doctorProfile)?$doctorInfo->doctorProfile->exequatur:null }}</td>
                <td><b>{{ trans("pdfLayout/admin_lang.specialities") }}</b>: {{ $doctorInfo->specializationString }}</td>
                <td><b>{{ trans("pdfLayout/admin_lang.phone") }}</b>: {{ $doctorInfo->userProfile->phone }} </td>
                <td><b>{{ trans("pdfLayout/admin_lang.email") }}</b>: {{ $doctorInfo->email }} </td>
            </tr>

        </table>
        <table class="bordered-table">
            <tr>
                <th colspan="4">{{ trans("pdfLayout/admin_lang.patient_info") }}</th>
            </tr>
            <tr class="table-text">
                <td><b>{{ trans("pdfLayout/admin_lang.name") }}</b>: {{ $info->user->userProfile->fullName }}</td>
                <td><b>{{ trans("pdfLayout/admin_lang.identification") }}</b>: {{ $info->user->userProfile->identification  }}</td>
                <td><b>{{ trans("pdfLayout/admin_lang.age") }}</b>: {{ $doctorInfo->userProfile->years}} </td>
                <td><b>{{ trans("pdfLayout/admin_lang.gender") }}</b>: {{ trans("pdfLayout/admin_lang.".$doctorInfo->userProfile->gender) }} </td>
            </tr>

        </table>
        <br><br>
        @yield('content')

        <div  style="margin-top:80px;">
            <div style="float: left; width:50%; text-align:left;">

                <hr class="  margin: 10px 0;">
                <label class='text-primary' for="">  {{ $doctorInfo->userProfile->fullName }}</label>
            </div>
            <div style="float: right; width:50%;text-align: right;">
                <label class='text-primary' for="">    {{ $date }}</label>
              
            </div>
        </div>
    </main>
</body>

</html>