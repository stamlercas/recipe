@extends ('layouts.master')

@section('title')
    Dashboard
@endsection

@section('content')
    <ul class="nav nav-pills nav-justified">
        <li class="active"><a data-toggle="pill" href="#home">Home</a></li>
        <li><a data-toggle="pill" href="#menu1">Trending</a></li>
        <!--
        <li><a data-toggle="pill" href="#menu2">Menu 2</a></li>
        <li><a data-toggle="pill" href="#menu3">Menu 3</a></li>
        -->
      </ul>
      <div id="dashboard">
          <div class="tab-content" style="margin-top:10px;">
            <div id="home" class="tab-pane in active">
              <h1>Welcome Back, {{ Auth::user()->first_name }}!</h1>
                <div>
                    <!-- BLOCKS GO HERE -->
                    <!-- EXAMPLES:
                        Trending
                        Cuisine of the day (ex:  There most popular cuisine is Mexican on Wednesday.  On Wednesday, display Taco Wednesday and a link to mexican dishes.  Or a link to past mexican dishes made or viewed on Wednesday.)
                        Recommendations (based on past searches, makes, and views; display recommendations on what to make.)
                        "You viewed this recently.  Did you make it?"
                    -->
                </div>
            </div>
            <div id="menu1" class="tab-pane">
                <div class="row">
                  <div class="col-sm-6 col-md-4" v-for="recipe in trending">
                    <div class="frame">
                    <div class="thumbnail">
                      <a :href="'{{ route('recipe.get', ['inventory_id' => ''])  }}/' + recipe.id">
                        <img :src="recipe.images.hostedLargeUrl" :alt="recipe.name + ' image'" />
                      </a>
                      <div class="caption">
                        <h3>
                          <a :href="'{{ route('recipe.get', ['inventory_id' => ''])  }}/' + recipe.id">
                            @{{ recipe.name }}
                          </a>
                        <save-icon :recipe_id="recipe.id" :saved="recipe.saved"></save-icon></h3>
                        <p><a :href="'{{ route('recipe.get', ['inventory_id' => ''])  }}/' + recipe.id" 
                            class="btn btn-primary" role="button">View</a></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="menu2" class="tab-pane">
              <h3>Menu 2</h3>
              <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
            </div>
            <div id="menu3" class="tab-pane">
              <h3>Menu 3</h3>
              <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
            </div>
          </div>
      </div>
    </div>


    <script>
        var trending = {!! json_encode($trending) !!};

        var save_recipe_url = "{{ route('recipe.save') }}";
        var session_token = "{{ Session::token() }}";
    </script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection