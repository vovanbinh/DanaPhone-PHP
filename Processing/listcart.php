<?php
session_start();
    if (isset($_SESSION["username"])) {
        $username = $_SESSION["username"];

    }else{
        echo "khong co user";
    }
    $nameproduct = '';
    $price = 0;
    $image = '';
    $quantity = 0;
    $id='';
    $stt = 0; 
    require_once '../Processing/connect.php';
    $sql = "SELECT cart.quantity, product.name, product.image, product.price, cart.id, product.id as idproduct  
    FROM cart 
    JOIN product ON cart.idproduct = product.id 
    WHERE username = '".$username."'";


    $result = mysqli_query($conn, $sql); 
    $response = "";
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $nameproduct = $row["name"];
            $price = $row['price'];
            $image = $row['image'];
            $quantity = $row['quantity'];
            $id = $row['id'];
            $idproduct = $row['idproduct'];
            $total = $price * $quantity;
            $formattedPrice = number_format($total, 0, '.', '.').' VND';
            $stt++;
            $response .= '<tr>';
            $response .= '<td>' . $stt . '</td>';
            $response .= '<td>' . $nameproduct . '</td>';
            $response .= '<td>' . $formattedPrice . '</td>';
            $response .= '<td>';
            if (!empty($image)) {
                $response .= '<img src="../Public/images/' . $image . '" alt="Ảnh Sản Phẩm" style="width: 100px;">';
            } else {
                $response .= '<span>Không có ảnh</span>';
            }
            $response .= '</td>';
            $response .= '<td style="max-width:120px;min-width:120px;">';
            $response .= '<div class="input-group input-group-sm">';
            $response .= '<span class="input-group-btn">
                            <button style=" max-height:32px; border:0.5px solid #DCDCDC; background-color:white;" type="button" class=" btn-number " data-type="minus" data-field="product-quantity">-</button>
                        </span>';
            $response .= '<input type="number" style="padding:0; min-height:30px; min-width:50px;  " name="product-quantity" id="product-quantity" class="form-control col-3 form-control-sm text-center" readonly value="' . $quantity . '" />';
            $response .= '<span class="input-group-btn">
                            <button style=" max-height:32px; border:0.5px solid #DCDCDC; background-color:white;" type="button" class=" btn-number" data-type="plus" data-field="product-quantity">+</button>
                        </span>';
            $response .= '</div>';
            $response .= '</td>';
            $response .= '<td>';
            $response .= '<div class="btn-group" role="group">';
            $response .= '<button type="button" class="delete-btn" data-id="' . $id . '" style="background-color: #dc3545; color: white; border: none;  max-height:35px; border-radius: 5px; cursor: pointer; ">Xoá</button>';
            $response .= '<button type="button" class="edit-btn" data-id="' . $id . '" data-idproduct="' . $idproduct . '" style="background-color: #009933; color: white; max-height:35px; margin-left:5px; border: none;  border-radius: 5px; cursor: pointer;">Cập Nhật</button>';
            $response .= '</div>';
            $response .= '</td>';
            $response .= '</tr>';        
        }
    }
    $conn->close();

    echo $response;
?>
