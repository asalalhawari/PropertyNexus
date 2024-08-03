<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="  https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  
</head>
<style>
    /* page2.css */

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f9f9f9;
}

.parent_items {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
    padding: 20px;
    
}

.item {
    
    width: 300px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 8px 12px gray;
   
    padding: 30px;
    display: flex;
    flex-direction: column;
    justify-content: space-around;
    align-items: center;
    text-align: center;
    gap:15px
   
   
}

.item img {
    width: 50%;
    border-radius: 8px;
}

.item h2 {
    margin-top: 20px;
    color: black;
}

.item p {
    font-size: 14px;
    color: #666;
    margin-top: 10px;
}

.crad-btn {
  width: 160px;
  height: 50px;
  border-radius: 5px;
  font-size: 15px;
  color: white;
  border: 1px solid rgb(0, 0, 0);

}

  .crad-btn a{
      color: black;
    text-decoration: none;   
  } 
  .back{
    width: 50px;
    height: 45px;
    margin-top: 45px;
    margin-left: 30px;
  }
  .back a{
   color:black;
  }
  
    </style>

<body>
    <button class="back"><a href="../index.php"> <i class="fa-solid fa-arrow-left"></i></a> </button>
    <div class="parent_items">

        <div class="item">
            <img src="../images/buy.jpg" >
            <h2>Buy a home</h2>
            <p>
                Find your place with an immersive photo experience and the most listings, including things you won’t find anywhere else.
            </p>
            <button class="crad-btn"><a href="../product.php">see more</a></button> 
        </div>
        <div class="item">
            <img src="../images/rent.jpg" >
            <h2>Rent a home</h2>
            <p>
                We’re creating a seamless online experience – from shopping on the largest rental network, to applying, to paying rent.            </p>
                <button class="crad-btn"><a href="../product.php">see more</a></button>       
             </div>
        <div class="item">
            <img src="../images/sell.jpg" >
            <h2>Rent a home</h2>
            <p>
                We’re creating a seamless online experience – from shopping on the largest rental network, to applying, to paying rent.            </p>
                <button class="crad-btn"><a href="../product.php">see more</a></button>     </div>
        
    </div>
<!-- <?php include '../include/footer'; ?> -->
</body>
</html>


