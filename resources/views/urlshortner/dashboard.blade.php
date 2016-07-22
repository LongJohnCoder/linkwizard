<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/bootstrap-theme.min.css">
  
  <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/style2.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="{{ URL::to('/').'/public/resources/js/bootstrap.min.js'}}"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.min.js"></script>

  
    
    
    

<style type="text/css">
.hero{
    position: relative;
    padding: 60px 0 60px 0;
    min-height: 800px;
    background: rgb(40, 70, 102) url("{{ URL::to('/').'/public/resources/img/city-overlay.png' }}") no-repeat center center;
    background-size: cover;
    color: #fff;
    width: 100%;
    height: 100%;
}

.texture-overlay {
    position: absolute;
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
    background-image: url("{{ URL::to('/').'/public/resources/img/grid.png' }}");
}
</style>
</head>
<body class="hero">

<section class="main-content" style="width:510px">
  
    <canvas id="myChart" width="400" height="400"></canvas>
  
</section>

<section class="main-content">
  <div class="texture-overlay"></div>
  <div class="container-fluid">
    <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bhoechie-tab-container">
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
                <div class="list-group">
                  <a href="#" class="list-group-item active">
                    <span class="date">jul 21</span>
                    <span class="title">google</span>
                    <span class="link">bit.ly/29WwggF</span>
                    <span class="count">0<i class="fa fa-signal" aria-hidden="true"></i></span>
                  </a>
                  <a href="#" class="list-group-item">
                    <span class="date">jul 21</span>
                    <span class="title">google</span>
                    <span class="link">bit.ly/29WwggF</span>
                    <span class="count">0<i class="fa fa-signal" aria-hidden="true"></i></span>
                  </a>
                  <a href="#" class="list-group-item">
                    <span class="date">jul 21</span>
                    <span class="title">google</span>
                    <span class="link">bit.ly/29WwggF</span>
                    <span class="count">0<i class="fa fa-signal" aria-hidden="true"></i></span>
                  </a>
                  <a href="#" class="list-group-item">
                    <span class="date">jul 21</span>
                    <span class="title">google</span>
                    <span class="link">bit.ly/29WwggF</span>
                    <span class="count">0<i class="fa fa-signal" aria-hidden="true"></i></span>
                  </a>
                  <a href="#" class="list-group-item">
                    <span class="date">jul 21</span>
                    <span class="title">google</span>
                    <span class="link">bit.ly/29WwggF</span>
                    <span class="count">0<i class="fa fa-signal" aria-hidden="true"></i></span>
                  </a>
                  <a href="#" class="list-group-item">
                    <span class="date">jul 21</span>
                    <span class="title">google</span>
                    <span class="link">bit.ly/29WwggF</span>
                    <span class="count">0<i class="fa fa-signal" aria-hidden="true"></i></span>
                  </a>
                </div>
              </div>
              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
                 
                  <div class="bhoechie-tab-content active">
                      <p class="date">jul 21</p>
                      <h1>google</h1>
                      <a href="https://www.google.co.in/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#q=sql+fing+a+repetation+in+a+column">https://www.google.co.in/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#q=sql+fing+a+repetation+in+a+column</a>

                      <a href="bit.ly/29WwggF" class="link">bit.ly/29WwggF</a>
                      <div class="buttons">
                        <a href="#">copy</a>
                        <a href="#">share</a>
                        <a href="#">edit</a>
                      </div>
                      <hr>
                      <p class="count">0<i class="fa fa-signal" aria-hidden="true"></i></p>
                      <div class="row">
                        <div class="col-sm-4"><h2>total clicks: 0</h2></div>
                        <div class="col-sm-2"></div>
                        <div class="col-sm-6 map-section">
                          
                           <div id="regions_div"></div>

                        </div>
                      </div>
                      
                     

                  </div>
                  
                  <div class="bhoechie-tab-content">
                      <center>
                        <h1 class="glyphicon glyphicon-road"></h1>
                        <h2>Cooming Soon</h2>
                        <h3>Train Reservation</h3>
                      </center>
                  </div>
                  
                  <div class="bhoechie-tab-content">
                      <center>
                        <h1 class="glyphicon glyphicon-home"></h1>
                        <h2>Cooming Soon</h2>
                        <h3>Hotel Directory</h3>
                      </center>
                  </div>

                  <div class="bhoechie-tab-content">
                      <center>
                        <h1 class="glyphicon glyphicon-cutlery"></h1>
                        <h2>Cooming Soon</h2>
                        <h3>Restaurant Diirectory</h3>
                      </center>
                  </div>

                  <div class="bhoechie-tab-content">
                      <center>
                        <h1 class="glyphicon glyphicon-credit-card"></h1>
                        <h2>Cooming Soon</h2>
                        <h3>Credit Card</h3>
                      </center>
                  </div>
              </div>
          </div>
    </div>
</div>
</section>
</body>

<script type="text/javascript">
$(document).ready(function() {
    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
});
</script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['geochart']});
      google.charts.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {

        var data = google.visualization.arrayToDataTable([
          ['Country', 'Popularity'],
          ['Germany', 200],
          ['United States', 300],
          ['Brazil', 400],
          ['Canada', 500],
          ['France', 600],
          ['RU', 700]
        ]);

        var options = {backgroundColor: '#81d4fa'};

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

        chart.draw(data, options);
      }
    </script>

    <script>
    var ctx = document.getElementById("myChart");


    dataset = {
            labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        };


    var myChart = new Chart(ctx, {
        type: 'bar',
        data: dataset,
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });

    
    </script>

</html>