          <nav class="navbar navbar-default navbar-fixed-side">
            <div class="container">
              <div class="navbar-header">
                <button class="navbar-toggle" data-target=".navbar-collapse" data-toggle="collapse">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand text-center" href="./">Recipr</a>
              </div>
              <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                <li>
                    <a href="{{ route('home') }}">
                      <i class="fa fa-home fa-5x"></i>
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('search') }}">
                      Search Recipes
                      <br />
                      <i class="fa fa-search fa-5x"></i>
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('inventory') }}">
                      Manage Pantry
                      <br />
                      <i class="fa fa-shopping-bag fa-5x"></i>
                    </a>
                  </li>
                  <li>
                    <a href="./">
                      Settings
                      <br />
                      <i class="fa fa-cog fa-5x"></i>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      {{ Auth::user()->username }}
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      Logout
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