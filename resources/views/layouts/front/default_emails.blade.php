<!DOCTYPE html>
<html>
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">	

		<title>
            @php
                    $setting =\App\Services\SettingsServices::getGeneral();
            @endphp
            @if(!empty($setting->site_name))
                {{ $setting->site_name }} ::
            @else
                {{ config('app.name', '') }} ::
              
            @endif
		</title>	

    <style>
        /* Estilos CSS aquí */
        body {
            margin: 0;
            padding: 0;
        }
    .mi-container {
            width: 90%;
            margin-right: auto;
            margin-left: auto;
        }
      .mi-container-fluid {
            width: 100%;
            padding-right: 0;
            padding-left: 0;
            margin-right: 0;
            margin-left: 0;
        }
        header {
            background-color: #ccc; /* Color gris */
            min-height: 150px;
            text-align: left;
            padding: 20px;
            box-sizing: border-box; /* Evita que el padding afecte el ancho total */
            margin-bottom:40px;
        }

        main {
             margin-bottom:40px;
              width: 100% !important;
        }
        footer {
              width: 100%;
              font-size:8px;
        }

        body {
            background-color: #fff; /* Color blanco */
        }
         .logo{
          width:20%;
          float:left;        
         
        }
         .site_name_container{
          width:80%;
          
          float:right;
        }
         .site_name_text{
            margin-left: 10px;
            margin-top: 33px;;
        }

        .btn {
          display: inline-block;
          font-weight: 400;
          text-align: center;
          white-space: nowrap;
          vertical-align: middle;
          user-select: none;
          border: 1px solid transparent;
          padding: 0.375rem 0.75rem;
          font-size: 1rem;
          line-height: 1.5;
          border-radius: 0.25rem;
          transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
      }

      .btn-primary {
          color: #fff;
          background-color: #183f72;
          border-color: #183f72 #183f72 #0f2848;
          text-decoration: none;
      }

      .btn:hover {
          color: #fff;
          text-decoration: none;
      }

      .btn:hover,
      .btn:focus {
          background-color: #1f5092;
          border-color: #004380;
      }


      /* Estilos para pantallas pequeñas (hasta 600px) */
      @media only screen and (max-width: 600px) {
       
         .logo{
          text-align:center;
          width:100%;
        }
         .site_name_container{
          text-align:center;
          width:100%;
        }
         .site_name_text{
              margin-left: 0px;
            margin-top: 20px;
        }
       

        /* Puedes agregar más reglas de estilo específicas para pantallas pequeñas aquí */
      }
    </style>

	  @yield('head_page')
	</head>
	<body >
  
    <div class="mi-container-fluid">
      <header>
      
          <div class="mi-container">
            <div class="logo" style=" height:80px;" >
                  @if(!empty($setting->image))
                      {{-- <img src='{{ url(' admin/settings/get-image/'.$setting->image) }}' class="" alt="Porto Admin" style="width:100%"> --}}
                      <img style="width:100%; height:100%; border-top: 2px solid black;" src="{{ asset('settings/'.$setting->image)}}" alt="{{ $setting->site_name }}" style="width:100%; height:100%; object-fit: fill;">
                  @else
                      <img src="{{ asset('assets/admin/img/logo.png')}}" alt="Porto Admin" style="width:100%; height:100%; object-fit: fill;">
                  @endif
            </div>
            <div class="site_name_container">
              <h3 class="site_name_text">{{ $setting->site_name }}</h3>              
            </div>        
          </div>
      </header>        
    </div>
      <div class="mi-container">
          @yield('content')
      </div>
      <footer class="mi-container">
          <hr/>
          <p  >
              {{ $setting->site_name }}. 
              {{ $setting->complete_address }},
              <i>tel:</i>{{ $setting->phone }}, 
              <i>email: </i>{{ $setting->email }}
          </p>
      </footer>

			
   
    
       @yield('foot_page')
  </body>
</html>
    