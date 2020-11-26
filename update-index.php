<?php
    include_once 'parser/helper.php';
    $config = getMainConfig();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <script type="text/javascript">
        if(window.location.protocol != 'https:') {
            window.location.href = "https://www.mastellazon.it"
        }
    </script>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta property="og:url"         content="https://www.mastellazon.it" />
    <meta property="og:type"        content="website" />
    <meta property="og:title"       content="Mastellazon - Lo shopping sannita" />
    <meta property="og:description" content="Lo sapevi che un negozio sannita può raggiungere clienti in tutta Italia?" />
    <meta property="og:image"       content="img/og.png" />

    <title>Mastellazon</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/mainbs.css" />
    <link rel="icon" href="img/icon.png" />
  </head>

  <body>
    <script src="https://cdn.jsdelivr.net/npm/jdenticon@3.0.1" async></script>
    <nav class="navbar fixed-top d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-dark border-bottom box-shadow">
        <a class="navbar-brand" href="#"><img src="img/logo.png" alt="Mastellazon"></a>
    </nav>
    <main role="main">
        <div class="main container">
            <div class="claim px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                <p>Ti svelo un segreto: anche un <u>piccolo artigiano o commerciante sannita</u>
                        può vendere su un marketplace come Amazon.</p>
                <p>Lo sapevi che <span class="store-number"><?php echo count($config->stores); ?></span> 
                    negozi sanniti sono già usciti dalla mentalità provinciale e raggiungono
                    clienti in tutta Italia?</p>
            </div>

            <div id="filters" class="btn-group px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">  
                <button class="btn btn-secondary btn-default" autofocus="autofocus" data-filter="*">Tutti</button>
                <?php foreach (makeIndex($config->stores) as $index): ?>
                    <button class="btn btn-secondary" data-filter=".<?php echo $index; ?>"><?php echo $index; ?></button>
                <?php endforeach; ?>
            </div>

            <div class="card-deck mb-3 text-center">
                <?php foreach ($config->stores as $store): ?>
                    <div id="store-<?php echo $store->slug; ?>" class="card mb-4 box-shadow <?php echo makeInitials($store->name); ?>">
                        <div class="card-header">
                            <h4 class="store-name"><?php echo $store->name; ?></h4>
                        </div>
                        <div class="card-body">
                            <div class="store-logo">
                                <svg data-jdenticon-value="user-<?php echo md5($store->slug); ?>" width="80" height="80">
                                    <!-- logo fallback -->
                                    <?php echo $store->name; ?>
                                    <!-- /logo fallback -->
                                </svg>
                            </div>
                            <div class="store-feedback"><?php echo $store->feedback; ?></div>
                            <span class="seller-contact-button a-button a-button-primary">
                                <span class="a-button-inner">
                                    <a href="<?php echo $store->link; ?>" target="_blank" rel="noopener" class="a-button-text store-link" role="button">
                                        Scopri
                                    </a>
                                </span>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <footer class="footer pt-4 fixed-bottom bg-dark text-white">
        <p class="text-white">Sei un negozio sannita e vuoi comparire su questa pagina assieme ai nostri amici sanniti? Semplice, inizia a vendere su Amazon.</p>
        <p> <img src="img/icon.png" alt="CyberFuffa" height="16" class="favicon"> Copyright &copy; CyberFuffa 2020 - Mastellazon - Dai Sanniti per i Sanniti</p>
    </footer>
  </body>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
        var contributorsTag = <?php echo getContributorsTags(); ?>;

        var $grid = $('.card-deck').isotope({
            itemSelector: '.card',
            layoutMode: 'fitRows',
            getSortData: {
                storeName: '.store-name'
            }
        });

        // filter functions
        var filterFns = {
            // show if number is greater than 50
            numberGreaterThan50: function() {
                var number = $(this).find('.number').text();
                return parseInt( number, 10 ) > 50;
            },
            // show if name ends with -ium
            ium: function() {
                var name = $(this).find('.name').text();
                return name.match( /ium$/ );
            }
        };

        // bind filter button click
        $('#filters').on( 'click', 'button', function() {
            var filterValue = $( this ).attr('data-filter');
            // use filterFn if matches value
            filterValue = filterFns[ filterValue ] || filterValue;
            $grid.isotope({ filter: filterValue });
        });

        // bind sort button click
        $('#sorts').on( 'click', 'button', function() {
            var sortByValue = $(this).attr('data-sort-by');
            $grid.isotope({ sortBy: sortByValue });
        });

        // random tags
        $('.store-link').each(function() {
            var tag = contributorsTag[Math.floor(Math.random() * contributorsTag.length)];
            var plainUrl = $(this).attr('href');
            var tagUrl = $(this).attr('href', plainUrl + tag);
        });
    });
  </script>
</html>
