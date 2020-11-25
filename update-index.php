<?php
    const CONFIG_FILE = 'public/config.json';
    $config = json_decode(file_get_contents(CONFIG_FILE));
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
    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/mainbs.css" />
    <link rel="icon" href="img/logo.png" />
  </head>

  <body>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jdenticon@3.0.1" async></script>
    <nav class="navbar d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-dark border-bottom box-shadow">
        <a class="navbar-brand" href="#"><img src="img/logo.png" alt="Mastellazon"></a>
    </nav>
    <div class="claim px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="lead">Ti svelo un segreto: anche un <u>piccolo artigiano o commerciante sannita</u>
                può vendere su un marketplace come Amazon.</h1>
        <h1 class="lead">Lo sapevi che <span class="store-number"><?php echo count($config->stores); ?></span> 
            negozi sanniti sono già usciti dalla mentalità provinciale e raggiungono
            clienti in tutta Italia?<h1>
    </div>
    <main role="main">
        <div class="container">
            <div class="card-deck mb-3 text-center">
                <?php foreach ($config->stores as $store): ?>
                    <div id="store-<?php echo $store->slug; ?>" class="card mb-4 box-shadow">
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
                                    <a href="<?php echo $store->link; ?>" target="_blank" rel="noopener" class="a-button-text" role="button">
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
    <footer class="container">
        <hr>
        <p>Sei un negozio sannita e vuoi comparire su questa pagina assieme ai nostri amici sanniti? Semplice, inizia a vendere su Amazon.</p>
        <p>Copyright (c) 2020 - Mastellazon - Dai Sanniti per i Sanniti</p>
    </footer>
  </body>
</html>