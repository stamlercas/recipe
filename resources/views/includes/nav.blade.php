          <nav class="navbar navbar-default navbar-fixed-side">
            <div class="container">
              <div class="navbar-header visible-xs" id="mobile-nav">
                <!-- mobile bar -->
                <div class="row mobile-navbar text-center">
                  <div class="col-xs-2 navbar-btn">
                    <a href="{{ route('dashboard') }}">
                      <i class="fa fa-home fa-lg"></i>
                    </a>
                  </div>
                  <div class="col-xs-2 navbar-btn">
                    <a href="{{ route('search.index') }}">
                      <i class="fa fa-search fa-lg"></i>
                    </a>
                  </div>
                  <div class="col-xs-2 navbar-btn">
                    <a href="{{ route('inventory') }}">
                      <i class="fa fa-shopping-basket fa-lg"></i>
                    </a>
                  </div>
                  <div class="col-xs-2 navbar-btn">
                    <a href="{{ route('grocery_lists') }}">
                      <i class="fa fa-shopping-cart fa-lg"></i>
                    </a>
                  </div>
                  <div class="col-xs-2 navbar-btn">
                    <a href="{{ route('settings') }}">
                      <i class="fa fa-cog fa-lg"></i>
                    </a>
                  </div>
                  <div class="col-xs-2 navbar-btn">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      <i class="fa fa-sign-out fa-lg"></i>
                    </a>
                  </div>
                </div>
              </div>
              <div class="navbar-header hidden-xs">
                <a class="navbar-brand text-center" href="./">Recipr</a>
              </div>
              <div class="collapse navbar-collapse" id="collapse">
                <ul class="nav navbar-nav" id="sidebar-nav">
                <li>
                    <a href="{{ route('home') }}">
                      <i class="fa fa-home fa-5x"></i>
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('search.index') }}">
                      Search Recipes
                      <br />
                      <i class="fa fa-search fa-5x"></i>
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('inventory') }}">
                      Manage Pantry
                      <br />
                      <i class="fa fa-shopping-basket fa-5x"></i>
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('grocery_lists') }}">
                      Grocery Lists
                      <br />
                      <i class="fa fa-shopping-cart fa-5x"></i>
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('settings') }}">
                      Settings
                      <br />
                      <i class="fa fa-cog fa-5x"></i>
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      Logout <i class="fa fa-sign-out fa-lg" aria-hidden="true"></i>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                  </li>
                  <!--
                  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Dropdown <b class="caret"></b></a><ul class="dropdown-menu"><li><a href="#">Sub-page 1</a></li>
                  <li><a href="#">Sub-page 2</a></li>
                  <li class="divider"></li>
                  <li class="dropdown-header">Dropdown Header</li>
                  <li><a href="#">Sub-page 3</a></li>
                  </ul></li>
                  -->
                </ul>
                <!--
                <form class="navbar-form navbar-left">
                  <div class="form-group">
                    <input class="form-control" placeholder="Search">
                  </div>
                  <button class="btn btn-default">Search</button>
                </form>
                <ul class="nav navbar-nav navbar-right">
                  <li><a href="#">Page 4</a></li>
                </ul>
                <button class="btn btn-default navbar-btn">Button</button>
                <p class="navbar-text">
                  Made by
                  <a href="http://www.samrayner.com">Sam Rayner</a>
                </p>
                -->
              </div>
            </div>
          </nav>
          <script src="{{ asset('js/app.js') }}"></script>
          <script>
            $(document).ready( function() {
              for(var i = 0; i < $("#sidebar-nav li").length; i++) {
                if ( "{{ Request::fullUrl() }}" === $("#sidebar-nav li:eq(" + i + ") a").attr("href") )
                  $("#sidebar-nav li:eq(" + i + ")").addClass("active-nav");
              }
            });
          </script>