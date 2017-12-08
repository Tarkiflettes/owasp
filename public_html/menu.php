<nav id='nav_bar'>
    <nav class ="navbar navbar-inverse">
        <div class="container">
            <div class="container-fluid">
                <ul class="nav navbar-nav">
                    <li class="<?php if($_SERVER['REQUEST_URI'] == '/accueil.php'){ echo 'active';} ?>">
                        <a href="accueil.php">Accueil</a>
                    </li>
                    <?php if(isset($_SESSION['id'])):?>
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/news.php'){ echo 'active';} ?>">
                            <a href="news.php">faille XSS</a>
                        </li>
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/include.php?url=tableau.php'){ echo 'active';} ?>">
                            <a href="include.php?url=tableau.php">Faille include</a>
                        </li>
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/membres.php'){ echo 'active';} ?>">
                            <a href="membres.php?membreId=1">injection SQL</a>
                        </li>
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/partenariats.php'){ echo 'active';} ?>">
                            <a href="partenariats.php">URI non secure</a>
                        </li>
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/notif.php'){ echo 'active';} ?>">
                            <a href="notif.php">notif</a>
                        </li>
                    <?php endif ?>
                </ul>

                <?php if (!isset($_SESSION['id'])): ?>

                    <form class='navbar-form navbar-right inline-form' action='connexion.php' method='POST'>
                        <div class='form-group'>
                            <input type='text' placeholder='nom' class='form-control1' name='nom'>
                        </div>
                        <div class='form-group'>
                            <input type='Password' placeholder='mot de passe' class='form-control1' name='mdp'>
                        </div>
                        <button type='submit' class='btn btn-success' >S'identifier</button>
                    </form>


                    }
                <?php else: ?>
                    <form class='navbar-form navbar-right inline-form' action='deconnexion.php' method='POST'>
                        <button type='submit' class='btn btn-success' >Deconnexion</button>
                    </form>
                    <form class='navbar-form navbar-right inline-form' action='profil.php' method='POST'>
                        <button type='submit' class='btn btn-success' >Profil</button>
                    </form>
                <?php endif ?>
                ?>
            </div>
        </div>
    </nav>
</nav>