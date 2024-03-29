<!-- 
    
Immaginare quali sono le classi necessarie per creare uno shop online con le seguenti caratteristiche:
- L'e-commerce vende prodotti per animali.
- I prodotti sono categorizzati, le categorie sono Cani o Gatti.
- I prodotti saranno oltre al cibo, anche giochi, cucce, etc.
 Stampiamo delle card contenenti i dettagli dei prodotti, come immagine, titolo, prezzo, icona della categoria ed il tipo di articolo che si sta visualizzando (prodotto, cibo, gioco, cuccia). 

Oggi continuate a lavorare nella stessa repo di ieri aggiungendo almeno un trait ed un exception al vostro shop!
nome repo di ieri: php-oop-2

-->

<?php
    class Product{

        use DescriptionTrait;
        use DiscountTrait;

        public $image;
        public $title;
        public $category;
        public $type;
        private $price; // set to private 

        //constructor

        public function __construct($_image, $_title, $_category, $_type, $_price){
            $this->image = $_image;
            $this->title = $_title;
            $this->category = $_category;
            $this->type = $_type;
            $this->price = $_price;
        }

        //getter func for price

        public function getPrice(){
            return $this->price;
        }

        //setter func for price
        public function setPrice($price){
            $this->price = $price;
        }

        // method to set category
        public function setCategory($category) {
            if ($category !== 'Cani' && $category !== 'Gatti') {
                return false;
            }
            $this->category = $category;
            return true;
        }
        
       
    }

    /*******************************************************
                Post correzione 12/03
    ********************************************************/

    class Cuccia extends Product {
        private $dimensions;
    
        public function __construct($_image, $_title, $_category, $_type, $_price, $_dimensions) {
            parent::__construct($_image, $_title, $_category, $_type, $_price);
            $this->dimensions = $_dimensions;
        }
    
        public function getDimensions() {
            return $this->dimensions;
        }
    }
    // set new instance for class "cuccia"
    $cuccia = new Cuccia('./img/cuccia.jpg', 'Cuccia per Cani', 'Cani', 'Cuccia', 50, '50x60x40 cm');




    $firstProduct = new Product('./img/crocchette.jpg', 'Crocchette', 'per cani', 'Cibo', 15);
    // echo "Original Price: " . $firstProduct->getPrice() . "<br>";

    $firstProduct->setPrice(20);

    // echo "Updated Price: " . $firstProduct->getPrice() . "<br>";

    $secondProduct = new Product('./img/collar.webp', 'Collare', 'per gatti', 'Accessorio', 10);
    $thirdProduct = new Product('./img/tennisball.jpeg', 'Pallina da tennis', 'per cani', 'Gioco', 5);

    
    // echo $firstProduct->getPrice(); //15

    // var_dump($firstProduct, $secondProduct, $thirdProduct);


        class InvalidCategoryException extends Exception {
            public function errorMessage() {
                return "Invalid category!";
            }
        }

        //trait 1
        trait DescriptionTrait{
            public function getDescription(){
                 return $this->title . ' - ' . $this->category . ' - ' . $this->type;
            }
        };

        // trait 2
        trait DiscountTrait {
            public function applyDiscount($discountPercentage) {
                $discountedPrice = $this->price * (1 - ($discountPercentage / 100));
                return round($discountedPrice, 2);
            }
        }

        //exception 1 

        /*****************************************************************************************************************************************************************************************
        SE SOSTITUISCO IL VALORE PESCI CON LE CATEGORIE CANI O GATTI LA FUNZIONE NON PRINTA L'ERRORE. SE METTO QUASIASI ALTRA COSA PRINTA L'ERRORE IN CIMA ALLA PAGINA 
        ******************************************************************************************************************************************************************************************/

        try {
            if(!$firstProduct->setCategory('Pesci')){
                echo '<div class="alert alert-danger" role="alert">Errore: Categoria non valida!</div>';
            }
        } catch (InvalidCategoryException $e) {
            echo '<div class="alert alert-danger" role="alert"> Error: ' . $e->getMessage() . '</div>';
        }
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce</title>
    
    <!-- Boostrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- My CSS -->
    <link rel="stylesheet" href="./style.css">

</head>
<body>
    <header>
        <div class="text-center mt-5">
            <h1>
                Animal Shop
            </h1>
            <h5 class="mt-3">
                Browse toys and food for dogs & cats. Your one-stop shop for their playful and dietary needs. Order online now!
            </h5>
        </div>
    </header>

    <main>
        <h3 class="text-center" style="margin-top: 150px">
            Browse toys and food...
        </h3>

        <div class="container">
            <div class="row">
                <?php foreach([$firstProduct, $secondProduct, $thirdProduct] as $element): ?>
                <div class="col-4">
                    <div class="card mt-5">
                        <img class="card-img-top" src="<?php echo $element->image; ?>" alt="<?php echo $element->title; ?>" style="height: 250px;"/>
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $element->title; ?></h4>
                            <p class="card-text">Categoria: <?php echo $element->category; ?></p>
                            <p class="card-text">Tipo: <?php echo $element->type; ?></p>
                            <p class="card-text">Prezzo originale: <?php echo $element->getPrice(); ?> €</p>

                            <p class="card-text text-success">Descrizione: <?php echo $element->getDescription();?></p>
                            <p class="card-text text-success">Prezzo dopo lo sconto applicato: <?php echo $element->applyDiscount(5);?> <p>
                            <p class="card-text">Dimensioni: <?php echo $cuccia->getDimensions(); ?></p> 
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js' integrity='sha512-WW8/jxkELe2CAiE4LvQfwm1rajOS8PHasCCx+knHG0gBHt8EXxS6T6tJRTGuDQVnluuAvMxWF4j8SNFDKceLFg==' crossorigin='anonymous'></script>
</body>
</html>