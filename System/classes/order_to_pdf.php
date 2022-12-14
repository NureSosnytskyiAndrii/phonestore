<?php
global $mysqli;
require_once "../configuration.php";
require("../fpdf/fpdf.php");


//customer and invoice details
$info=[
    "order_#"=>"",
    "name"=>"",
    "surname"=>"",
    "email"=>"",
    "phone"=>"",
    "total"=>"",
    "order_date"=>"",

];


$order_id = $_GET['id'];
$order_info = $mysqli->query( "SELECT * FROM `order` WHERE order_id='$order_id'") or die($mysqli->error);

if(mysqli_num_rows($order_info) > 0){
    $order_info = mysqli_fetch_assoc($order_info);
    $info=[
        "order_#"=>$order_info['order_id'],
        "name"=>$order_info['name'],
        "surname"=>$order_info['surname'],
        "email"=>$order_info['email'],
        "phone"=>$order_info['phone_number'],
        "total"=>$order_info['cost'],
        "order_date"=>$order_info['order_date'],
    ];
}

//invoice Products
$products_info=[];

$selected_goods = $mysqli->query("select order_items.quantity, smartphone.model, smartphone.price, smartphone.warranty from order_items, smartphone WHERE
          order_items.order_id = '$order_id' AND smartphone.smartphone_id =order_items.smartphone_id ");
if(mysqli_num_rows($selected_goods) > 0){
    while ($row = mysqli_fetch_assoc($selected_goods)) {
        $products_info[] =[
            "name"=>$row['model'],
            "warranty"=>$row['warranty'],
            "price"=>$row['price'],
            "quantity"=>$row['quantity'],
            "total"=>$row['price'] * $row['quantity'],
        ];
    }
}

class PDF extends FPDF
{
    function Header(){

        //Display Company Info
        $this->SetFont('Arial','B',14);
        $this->Cell(50,10,"PhoneStore",0,1);
        $this->SetFont('Arial','',14);
        $this->Cell(50,7,"Heroiv pratsi Street, 9",0,1);

        //Display INVOICE text
        $this->SetY(15);
        $this->SetX(-40);
        $this->SetFont('Arial','B',18);
        $this->Cell(50,10,"RECEIPT",0,1);

        //Display Horizontal line
        $this->Line(0,48,210,48);
    }

    function body($info,$products_info){

        //Billing Details
        $this->SetY(55);
        $this->SetX(10);
        $this->SetFont('Arial','B',12);
        $this->Cell(50,10,"Bill To: ",0,1);
        $this->SetFont('Arial','',12);
        $this->Cell(50,7,$info["name"],0,1);
        $this->Cell(50,7,$info["surname"],0,1);
        $this->Cell(50,7,$info["email"],0,1);
        $this->Cell(50,7,$info["phone"],0,1);

        //Display order date
        $this->SetY(55);
        $this->SetX(-90);
        $this->Cell(50,7,"Order date : ".$info["order_date"]);

        //Display order id
        $this->SetY(71);
        $this->SetX(-60);
        $this->Cell(50,7,"Order_# : ".$info["order_#"]);

        //Display Table headings
        $this->SetY(95);
        $this->SetX(10);
        $this->SetFont('Arial','B',12);
        $this->Cell(60,9,"DESCRIPTION",1,0);
        $this->Cell(40,9,"PRICE",1,0,"C");
        $this->Cell(20,9,"WARR",1,0,"C");
        $this->Cell(30,9,"QTY",1,0,"C");
        $this->Cell(40,9,"TOTAL",1,1,"C");
        $this->SetFont('Arial','',12);

        //Display table product rows
        foreach($products_info as $row){
            $this->Cell(60,9,$row["name"],"LR",0);
            $this->Cell(40,9,$row["price"],"R",0,"R");
            $this->Cell(20,9,$row["warranty"],"R",0,"C");
            $this->Cell(30,9,$row["quantity"],"R",0,"R");
            $this->Cell(40,9,$row["total"],"R",1,"R");
        }
        //Display table empty rows
        for($i=0;$i<12-count($products_info);$i++)
        {
            $this->Cell(60,9,"","LR",0);
            $this->Cell(40,9,"","R",0,"R");
            $this->Cell(20,9,"","R",0,"R");
            $this->Cell(30,9,"","R",0,"C");
            $this->Cell(40,9,"","R",1,"R");
        }
        //Display table total row
        $this->SetFont('Arial','B',12);
        $this->Cell(150,9,"TOTAL",1,0,"R");
        $this->Cell(40,9,$info["total"],1,1,"R");


    }
    function Footer(){

        //set footer position
        $this->SetY(-50);
        $this->SetFont('Arial','B',12);
        $this->Cell(0,10,"for PhoneStore",0,1,"R");
        $this->Ln(15);
        $this->SetFont('Arial','',12);
        $this->Cell(0,10,"Authorized Signature",0,1,"R");
        $this->SetFont('Arial','',10);

        //Display Footer Text
        $this->Cell(0,10,"This is a PhoneStore invoice",0,1,"C");

    }

}
//Create A4 Page with Portrait
$pdf=new PDF("P","mm","A4");
$pdf->AddPage();
$pdf->body($info,$products_info);
$pdf->Output();
?>
