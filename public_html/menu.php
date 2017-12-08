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
                            <a href="news.php">news</a>
                        </li>
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/include.php?url=tableau.php'){ echo 'active';} ?>">
                            <a href="include.php?url=tableau.php">Faille include</a>
                        </li>
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/membres.php'){ echo 'active';} ?>">
                            <a href="membres.php">membres</a>
                        </li>
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/partenariats.php'){ echo 'active';} ?>">
                            <a href="partenariats.php">partenariats</a>
                        </li>
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/notif.php'){ echo 'active';} ?>">
                            <a href="notif.php">notif</a>
                        </li>
                    <?php endif ?>
                </ul>

                <?php
                $req = $db->prepare("SELECT * FROM nomasso WHERE idasso = :id");

                $req->execute(array(':id' => $_SESSION['id']));
                $donnees = $req->fetch();
                ?>

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
                        <button type='submit' class='btn btn-success' >Profil <?= $donnees['nomasso'] ?></button>
                    </form>
                <?php endif ?>
                ?>
            </div>
        </div>
    </nav>
</nav>