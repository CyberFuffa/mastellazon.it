<?php
    const CONFIG_FILE = 'config.json';
    $config = json_decode(file_get_contents(CONFIG_FILE));
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Mastellazon</title>
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="icon" href="images/favicon.png" />
  </head>

  <body>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jdenticon@3.0.1" async></script>
    <div id="header">
        <img src="img/logo.png" alt="Mastellazon">
    </div>
    <div id="main">
        <h1>Ti svelo un segreto: anche un piccolo artigiano o commerciante sannita
            può vendere su un marketplace come Amazon</h1>
        <h1>Lo sapevi che <span class="store-number"><?php echo count($config->stores); ?></span> 
        negozi sanniti sono già usciti dalla mentalità provinciale e raggiungono
        clienti in tutta Italia?<h1>
        <ul id="stores">
            <?php foreach ($config->stores as $store): ?>
                <li id="store-<?php echo $store->slug; ?>" class="store">
                    <h2 class="store-name"><?php echo $store->name; ?></h2>
                    <div class="store-logo">
                        <svg data-jdenticon-value="user-<?php echo md5($store->slug); ?>" width="80" height="80">
                            <!-- logo fallback -->
                            <?php echo $store->name; ?>
                            <!-- /logo fallback -->
                        </svg>
                    </div>
                    <div class="store-feedback"><?php echo $store->feedback; ?></div>
                    <span id="seller-contact-button" class="a-button a-button-primary">
                        <span class="a-button-inner">
                            <a href="<?php echo $store->link; ?>" target="_blank" rel="noopener" class="a-button-text" role="button">
                                Entra nel negozio sannita!
                            </a>
                        </span>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div id="pre-footer">
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed suscipit sapien massa, ut gravida enim scelerisque interdum. Sed eget dui odio. In a sagittis dolor. 
    </div>
    <div id="footer">
        Copyright (c) 2020 - Mastellazon - Dai Sanniti per i Sanniti
    </div>
  </body>
</html>