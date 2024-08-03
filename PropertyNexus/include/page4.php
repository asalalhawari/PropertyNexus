<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RoomSizer Pro</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        header {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative; 
            z-index: 999;
            
        }

        /* .menu-icon {
            font-size: 1.rem;
            cursor: pointer;
            position: absolute;
            left: 1rem; 
        } */

        h1 {
            font-size: 1.75rem; 
            margin: 0;
            color: #007BFF; 
        }

        main {
            padding: 10px;
            /* width: 100%; Reduced width for main container */
            margin: 0px 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        
             /* Center the main container */
        }

        .measurement-container {
            display: flex;
            /* align-items: stretch; */
            gap: 5px;
        }


        .main-img img {
            width: 100%;
            height: 100%;
            border-radius: 8px;
            object-fit: cover;
        }

        .measurement-details {
            flex: 1; /* Smaller width for the measurement details */
            background-color: #fff;
            border-radius: 12px;
            /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
            padding: 10px;
            text-align: left;

        }

        .measurement-details h2 {
            font-size: 1.5rem;
            color: #333;
        }

        .measurement-details table {
            width: 100%;
            border-collapse: collapse;
          
    
        }

        .measurement-details th, .measurement-details td {
            border: 1px solid #ddd;
            padding: 0.40rem;
            text-align: left;
        }

        .measurement-details th {
            background-color: #f2f2f2;
        }

        i {
            padding: 10px;
        }

       .icon{
            border-radius:5px;
            border: 1px solid rgb(0, 0, 0);
            background-color: rgba(219, 219, 219, 0.849);
            color: white;
            font-size: 14px;
            width: 60px;
            height: 30px;
            display: flex;
  justify-content: Center;
  align-items: center;
  color:black;
        }

        .btn {
            display: flex;
    
            padding: 10px;
            gap: 20px;
        }
    </style>
</head>
<body>
    <main>
        <div class="measurement-container">
            <div class="main-img">
                <img src="https://th.bing.com/th/id/OIP.nmY2o1MdUEMRBhFkRVxkyAHaGF?rs=1&pid=ImgDetMain" alt="Main Image">
            </div>
            <div class="measurement-details">
            <h2>Details</h2>
                <p>jndcjdnjnjncxz,la,lz;.</p>

                <table>
                    <tr>
                        <th>Number of rooms</th>
                        <td>Living Room</td>
                    </tr>
                    <tr>
                        <th>Width</th>
                        <td>15 ft</td>
                    </tr>
                    <tr>
                        <th>Length</th>
                        <td>20 ft</td>
                    </tr>
                    <tr>
                        <th>Room</th>
                        <td>Kitchen</td>
                    </tr>
                    <tr>
                        <th>Number of bathrooms</th>
                        <td>Bathroom</td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td>8 ft</td>
                    </tr>
                    <tr>
                        <th>Age of construction</th>
                        <td>10 ft</td>
                    </tr>
                    <tr>
                        <th>Owner's number</th>
                        <td>80 sq ft</td>
                    </tr>
                </table>
        
            </div>
        </div>
        <div class="btn">
                    <button class="icon"><i class="fa-solid fa-phone"></i></button>
                    <button  class="icon"><i class="fa-solid fa-location-dot"></i></button>
                    <button  class="icon"><i class="fa-solid fa-paperclip"></i></button>
                    <button  class="icon"><i class="fa-solid fa-comment"></i></button>
                </div>
    </main>
</body>
</html>
