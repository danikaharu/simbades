   <!-- header section strats -->
   <header class="header_section long_section px-0">
       <nav class="navbar navbar-expand-lg custom_nav-container">
           <a class="navbar-brand" href="{{ route('user.dashboard') }}">
               <span> {{ config('app.name') }} </span>
           </a>
           <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
               aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class=""> </span>
           </button>

           <div class="collapse navbar-collapse" id="navbarSupportedContent">
               <div class="d-flex mx-auto flex-column flex-lg-row align-items-center">
               </div>
               <div class="quote_btn-container">
                   <a href="{{ route('user.dashboard') }}">
                       <span>Beranda</span>
                       <i class="fa fa-home" aria-hidden="true"></i>
                   </a>
                   @auth()
                       <a href="{{ route('admin.dashboard') }}">
                           <span>Panel Admin</span>
                           <i class="fa fa-user" aria-hidden="true"></i>
                       </a>
                   @else
                       <a href="{{ route('login') }}">
                           <span>Login</span>
                           <i class="fa fa-user" aria-hidden="true"></i>
                       </a>
                   @endauth

               </div>
           </div>
       </nav>
   </header>
   <!-- end header section -->
