<?php
global $mysqli;
require_once "../configuration.php";
require ("../fpdf/fpdf.php");

//customer and invoice details
$info=[
    "Provider_name"=>"",
    "Provider_surname"=>"",
    "Email"=>"",
    "Address"=>"",
    "Date"=>"",
    "total_sum"=>"",
    "invoice_num"=>"",
    "words"=>"Rupees Five Thousand Two Hundred Only",
];

$tz = 'Europe/Kiev';
$timestamp = time();
$dt = new DateTime("now", new DateTimeZone($tz));
$dt->setTimestamp($timestamp);
$current_date = $dt->format('d-m-Y');

$invoice_num = rand() . "\n";

$grand_total =  $_GET["cost"];

$provider_id = $_GET['id'];
$chosen_provider = $mysqli->query("SELECT * FROM `provider` WHERE provider_id = '$provider_id'");
$necessary_phones = $mysqli->query("SELECT * FROM `invoice_products` ORDER BY QTY ASC");


    $chosen_provider = mysqli_fetch_assoc($chosen_provider);
    $info=[
        "Provider_name"=>$chosen_provider['provider_name'],
        "Provider_surname"=>$chosen_provider['provider_surname'],
        "Email"=>$chosen_provider['email'],
        "Address"=>$chosen_provider['address'],
        "Date"=>$current_date,
        "total_sum"=>$grand_total,
        "invoice_num"=>$invoice_num,
    ];

//invoice Products
$products_info=[];
if(mysqli_num_rows($necessary_phones) > 0) {
    while ($row = mysqli_fetch_assoc($necessary_phones)) {
        $products_info[] = [
            "Model" => $row['PNAME'],
            "Price" => $row['PRICE'],
            "Quantity" => $row['QTY'],
            "Total" => $row['TOTAL'],
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
        $this->Cell(50,7,"Heroiv Pratsi str,9",0,1);
        $this->Cell(50,7,"Owner: Andrii Sosnytskyi",0,1);

        //Display INVOICE text
        $this->SetY(15);
        $this->SetX(-40);
        $this->SetFont('Arial','B',18);
        $this->Cell(50,10,"INVOICE",0,1);

        //Display Horizontal line
        $this->Line(0,48,210,48);
    }

    function body($info,$products_info){

        //Billing Details
        $this->SetY(55);
        $this->SetX(10);
        $this->SetFont('Arial','B',12);
        $this->Cell(50,10,"Provider: ",0,1);
        $this->SetFont('Arial','',12);
        $this->Cell(50,7,$info["Provider_name"],0,1);
        $this->Cell(50,7,$info["Provider_surname"],0,1);
        $this->Cell(50,7,$info["Email"],0,1);

        //Display Invoice no
        $this->SetY(55);
        $this->SetX(-90);
        $this->Cell(50,7,"Address : ".$info["Address"]);

        //Display Invoice date
        $this->SetY(63);
        $this->SetX(-90);
        $this->Cell(50,7,"Invoice Date : ".$info["Date"]);

        $this->SetY(70);
        $this->SetX(-90);
        $this->Cell(50,7,"Delivery address : Kharkiv city, Heroiv pratsi, 9");

        $this->SetY(78);
        $this->SetX(-90);
        $this->Cell(50,7,"Invoice number : ".$info['invoice_num']);

        //Display Table headings
        $this->SetY(95);
        $this->SetX(10);
        $this->SetFont('Arial','B',12);
        $this->Cell(80,9,"DESCRIPTION",1,0);
        $this->Cell(40,9,"PRICE",1,0,"C");
        $this->Cell(30,9,"QTY",1,0,"C");
        $this->Cell(40,9,"TOTAL",1,1,"C");
        $this->SetFont('Arial','',12);

        //Display table product rows
        foreach($products_info as $row){
            $this->Cell(80,9,$row["Model"],"LR",0);
            $this->Cell(40,9,$row["Price"],"R",0,"R");
            $this->Cell(30,9,$row["Quantity"],"R",0,"C");
            $this->Cell(40,9,$row["Total"],"R",1,"R");
        }
        //Display table empty rows
        for($i=0;$i<12-count($products_info);$i++)
        {
            $this->Cell(80,9,"","LR",0);
            $this->Cell(40,9,"","R",0,"R");
            $this->Cell(30,9,"","R",0,"C");
            $this->Cell(40,9,"","R",1,"R");
        }
        //Display table total row
        $this->SetFont('Arial','B',12);
        $this->Cell(150,9,"TOTAL",1,0,"R");
        $this->Cell(40,9,$info["total_sum"],1,1,"R");


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
        $this->Cell(0,10,"This is a generated invoice",0,1,"C");

    }

}
//Create A4 Page with Portrait
$pdf=new PDF("P","mm","A4");
$pdf->AddPage();
$pdf->body($info,$products_info);
$pdf->Output();
mysqli_query($mysqli, "DELETE FROM `invoice_products`");
?>