<?php
session_start();
include "connect.php";

// Fetch all projects from the database using PDO directly
$sql = "SELECT * FROM portfolio_projects WHERE is_archived = 0";
$stmt = $db->query($sql);
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION['form_sent']) && $_SESSION['form_sent'] === true) {
  $successMessage = "Message bien envoyé. Réponse dans les meilleurs délais.";
  unset($_SESSION['form_sent']);
}




?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>AntoniSDev</title>
  <!-- Favicon-->
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
  <!-- Font Awesome icons (free version)-->
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <!-- Google fonts-->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
  <!-- Core theme CSS (includes Bootstrap)-->
  <link href="css/styles.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
  <!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>


</head>

<body id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand" href="#page-top">AntoniSDEV</a>
      <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#portfolio">Portfolio</a></li>
          <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#about">About</a></li>
          <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#contact">Contact</a></li>
          <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="backoffice.php">Admin</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Masthead-->
  <header class="masthead bg-primary text-white text-center">
    <div class="container d-flex align-items-center flex-column">
      <!-- Masthead Avatar Image-->
      <img class="masthead-avatar mb-5 rounded-circle" src="assets/img/me.jpg" alt="..." />
      <!-- Masthead Heading-->
      <h1 class="masthead-heading text-uppercase mb-0">je suis pas dev</h1>
      <!-- Icon Divider-->
      <div class="divider-custom divider-light">
        <div class="divider-custom-line"></div>
        <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
        <div class="divider-custom-line"></div>
      </div>
      <!-- Masthead Subheading-->
      <p class="masthead-subheading font-weight-light mb-0">En formation développeur web - web mobile</p>
    </div>
  </header>


  <!-- Portfolio Section-->
  <section class="page-section portfolio" id="portfolio">
    <div class="container">
      <!-- Portfolio Section Heading-->
      <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Portfolio</h2>
      <!-- Icon Divider-->
      <div class="divider-custom">
        <div class="divider-custom-line"></div>
        <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
        <div class="divider-custom-line"></div>
      </div>
      <!-- Portfolio Grid Items-->
      <div class="row justify-content-center">
        <!-- Portfolio Item-->
        <?php foreach ($projects as $index => $project) : ?>
          <div class="col-md-6 col-lg-4 mb-5">
            <div class="portfolio-item mx-auto" onclick="openModal(<?= $index ?>)">
              <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
              </div>
              <img class="img-fluid" src='assets/img/portfolio/<?= htmlspecialchars($project["project_screen"]) ?>' alt='Screenshot'>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>




  <!-- About Section-->
  <section class="page-section bg-primary text-white mb-0" id="about">
    <div class="container">
      <!-- About Section Heading-->
      <h2 class="page-section-heading text-center text-uppercase text-white">About</h2>
      <!-- Icon Divider-->
      <div class="divider-custom divider-light">
        <div class="divider-custom-line"></div>
        <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
        <div class="divider-custom-line"></div>
      </div>
      <!-- About Section Content-->
      <div class="row">
        <div class="col-lg-4 ms-auto">
          <p class="lead">Je m’appelle Antoni et j’ai 42 ans. Après avoir exercé le métier de cuisinier pendant plusieurs années, j’ai décidé de me reconvertir dans le développement web et web mobile. J’ai entamé une formation afin d’apprendre les bases pour pouvoir concevoir des sites et des applications. </p>
        </div>
        <div class="col-lg-4 me-auto">
          <p class="lead">Au cours de cette formation, j’ai également découvert le développement de jeux vidéo, et je souhaite maintenant approfondir mes connaissances en apprenant Unity et le pixel art, pour réaliser mes propres projets ludiques!</p>
        </div>
      </div>
      <!-- About Section Button-->
      <div class="text-center mt-4">
        <a class="btn btn-xl btn-outline-light" href="https://mempoule.lol/antoni/CV.pdf" target="_blank">
          <i class="fas fa-download me-2"></i>
          Mon CV
        </a>
      </div>
    </div>
  </section>

  <!-- Contact Section-->
  <section class="page-section" id="contact">
    <div class="container">
      <!-- Contact Section Heading-->
      <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Contact Me</h2>
      <!-- Icon Divider-->
      <div class="divider-custom">
        <div class="divider-custom-line"></div>
        <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
        <div class="divider-custom-line"></div>
      </div>
      <!-- Contact Section Form-->
      <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">





          <section id="contact">

            <div class="container">




              <div class="row">
                <div class="col-lg-8 offset-lg-2">
                  <!-- Ouverture du formulaire avec ses attributs:  id, method, action, role (facultatif)-->
                  <form id="contact-form" method="post" action="contact.php" role="form">




                    <div class="row">
                      <div class="col-lg-6">
                        <label for="firstname">Prénom <span class="etoile">*</span></label>
                        <input id="firstname" type="text" name="firstname" class="form-control" placeholder="Votre prénom">
                        <p class="comments"></p>
                      </div>


                      <div class="col-lg-6">
                        <label for="name">Nom <span class="etoile">*</span></label>
                        <input id="name" type="text" name="name" class="form-control" placeholder="Votre Nom">
                        <p class="comments"></p>
                      </div>


                      <div class="col-lg-6">
                        <label for="email">Email <span class="etoile">*</span></label>
                        <input id="email" type="text" name="email" class="form-control" placeholder="Votre Email">
                        <p class="comments"></p>
                      </div>


                      <div class="col-lg-6">
                        <label for="phone">Téléphone</label>
                        <input id="phone" type="tel" name="phone" class="form-control" placeholder="Votre Téléphone">
                        <p class="comments"></p>
                      </div>


                      <div class="col-lg-12">
                        <label for="message">Message <span class="etoile">*</span></label>
                        <textarea id="message" name="message" class="form-control" placeholder="Votre Message" rows="4"></textarea>
                        <p class="comments"></p>
                      </div>


                      <div class="col-lg-12">
                        <p class="etoile"><strong>* Ces informations sont requises.</strong></p>
                      </div>


                      <div class="col-lg-12 text-end">
                        <input type="submit" class="btn btn-xl sendbtn" value="Envoyer">

                        <!-- ceci est ma clé recaptcha coté client-->
                        <div class="g-recaptcha" data-sitekey="6LfNfookAAAAAKg7baUfn3khT4QOb2VZAsSqthHB">

                        </div>
                      </div>
                    </div>


                  </form>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </section>












  <!-- Footer-->
  <footer class="footer text-center">
    <div class="container">
      <div class="row">
        <!-- Footer Location-->
        <div class="col-lg-4 mb-5 mb-lg-0">
          <h4 class="text-uppercase mb-4">Adresse</h4>
          <p class="lead mb-0">
            Nevers 58000
          </p>
        </div>
        <!-- Footer Social Icons-->
        <div class="col-lg-4 mb-5 mb-lg-0">
          <h4 class="text-uppercase mb-4">Réseaux</h4>
          <a class="btn btn-outline-light btn-social mx-1" href="https://github.com/AntoniSDev"><i class="fab fa-fw fa-github"></i></a>
          <a class="btn btn-outline-light btn-social mx-1" href="https://www.linkedin.com/in/antoni-salomon-17821b267/"><i class="fab fa-fw fa-linkedin-in"></i></a>
        </div>
        <!-- Footer About Text-->
        <div class="col-lg-4">
          <h4 class="text-uppercase mb-4">Je suis pas Dev</h4>
          <p class="lead mb-0">
            Portfolio réalisé en bootstrap <br> et php pour le back office.
          </p>
        </div>
      </div>
    </div>
  </footer>








  <!-- Copyright Section-->
  <div class="copyright py-4 text-center text-white">
    <div class="container"><small>Copyright &copy; lorem ipsum 58000</small></div>
  </div>










  <!-- Portfolio Modals-->
  <?php foreach ($projects as $index => $project) : ?>
    <div class="portfolio-modal modal fade" id="portfolioModal<?= $index ?>" tabindex="-1" aria-labelledby="portfolioModal1" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button></div>
          <div class="modal-body text-center pb-5">
            <div class="container">
              <div class="row justify-content-center">
                <div class="col-lg-8">
                  <!-- Portfolio Modal - Title-->
                  <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0"><?= htmlspecialchars($project["project_name"]) ?></h2>
                  <!-- Icon Divider-->
                  <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                  </div>
                  <!-- Portfolio Modal - Image-->
                  <img class="img-fluid rounded mb-5" src="assets/img/portfolio/<?= htmlspecialchars($project["project_screen"]) ?>" alt="<?= htmlspecialchars($project["project_name"]) ?>" />
                  <!-- Portfolio Modal - Text-->
                  <p class="mb-4"><?= htmlspecialchars($project["project_details"]) ?></p>
                  <!-- Portfolio Modal - Links -->
                  <?php if (!empty($project["project_link"])) : ?>
                    <a href="<?= htmlspecialchars($project["project_link"]) ?>" class="btn btn-primary" target="_blank">
                      <i class="fas fa-external-link-alt fa-fw"></i>
                      Voir le projet
                    </a>
                  <?php endif; ?>
                  <?php if (!empty($project["project_git"])) : ?>
                    <a href="<?= htmlspecialchars($project["project_git"]) ?>" class="btn btn-primary" target="_blank">
                      <i class="fab fa-github fa-fw"></i>
                      Voir sur GitHub
                    </a>
                  <?php endif; ?>
                  <button class="btn btn-primary" data-bs-dismiss="modal">
                    <i class="fas fa-xmark fa-fw"></i>
                    Fermer la fenêtre
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>





  <!-- Core theme JS-->
  <script src="js/scripts.js"></script>
  <!-- Sciprt pour validation ReCaptcha-->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

  <script>
    // Fonction pour ouvrir le bon modal lorsque l'utilisateur clique sur une image
    function openModal(index) {
      var modal = new bootstrap.Modal(document.getElementById('portfolioModal' + index));
      modal.show();
    }
  </script>

  <?php if (isset($successMessage)) : ?>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
          icon: 'success',
          title: 'Success!',
          text: '<?= $successMessage ?>',
          confirmButtonText: 'OK',
          // You can customize the appearance and behavior of the notification here.
        });
      });
    </script>
  <?php endif; ?>








</body>

</html>