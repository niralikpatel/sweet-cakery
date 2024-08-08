<?php
require('fpdf/fpdf.php'); // Adjust the path as necessary

// Get the order ID from the POST request
$order_id = $_POST['invoice'];

// Connect to the database
include 'components/connection.php';

// Fetch order details
$sql_order = "SELECT * FROM orders WHERE order_id = :order_id";
$query_order = $conn->prepare($sql_order);
$query_order->bindParam(':order_id', $order_id, PDO::PARAM_INT);
$query_order->execute();
$order = $query_order->fetch(PDO::FETCH_OBJ);

// Fetch billing details
$sql_billing = "SELECT * FROM billing WHERE order_id = :order_id";
$query_billing = $conn->prepare($sql_billing);
$query_billing->bindParam(':order_id', $order_id, PDO::PARAM_INT);
$query_billing->execute();
$billing = $query_billing->fetch(PDO::FETCH_OBJ);

// Fetch order items
$sql_items = "SELECT * FROM order_items WHERE order_id = :order_id";
$query_items = $conn->prepare($sql_items);
$query_items->bindParam(':order_id', $order_id, PDO::PARAM_INT);
$query_items->execute();
$items = $query_items->fetchAll(PDO::FETCH_OBJ);

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Invoice', 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Order Details
$pdf->Cell(0, 10, 'Order ID: ' . htmlspecialchars($order->order_id), 0, 1);
$pdf->Cell(0, 10, 'Order Date: ' . htmlspecialchars($order->order_date), 0, 1);
$pdf->Cell(0, 10, 'Order Status: ' . htmlspecialchars($order->order_status), 0, 1);
$pdf->Ln(10);

// Billing Details
$pdf->Cell(0, 10, 'Billing Details', 0, 1, 'B');
$pdf->Cell(0, 10, 'Name: ' . htmlspecialchars($billing->first_name), 0, 1);
$pdf->Cell(0, 10, 'Email: ' . htmlspecialchars($billing->email), 0, 1);
$pdf->Cell(0, 10, 'Phone: ' . htmlspecialchars($billing->phone_number), 0, 1);
$pdf->Cell(0, 10, 'Delivery Date: ' . htmlspecialchars($billing->delivery_date), 0, 1);
$pdf->Cell(0, 10, 'Address: ' . htmlspecialchars($billing->address), 0, 1);
$pdf->Cell(0, 10, 'City: ' . htmlspecialchars($billing->city), 0, 1);
$pdf->Cell(0, 10, 'State: ' . htmlspecialchars($billing->state), 0, 1);
$pdf->Cell(0, 10, 'Pincode: ' . htmlspecialchars($billing->pincode), 0, 1);
$pdf->Cell(0, 10, 'Message on Cake: ' . htmlspecialchars($billing->message_on_cake), 0, 1);
$pdf->Ln(10);

// Order Items
$pdf->Cell(0, 10, 'Order Items', 0, 1, 'B');
$pdf->Cell(80, 10, 'Item Name', 1);
$pdf->Cell(30, 10, 'Quantity', 1);
$pdf->Cell(30, 10, 'Price', 1);
$pdf->Cell(30, 10, 'Weight', 1);
$pdf->Ln();

foreach ($items as $item) {
    $sql_item = "SELECT item_name, item_img FROM items WHERE item_id = :item_id";
    $query_item = $conn->prepare($sql_item);
    $query_item->bindParam(':item_id', $item->item_id, PDO::PARAM_INT);
    $query_item->execute();
    $item_details = $query_item->fetch(PDO::FETCH_OBJ);

    $pdf->Cell(80, 10, htmlspecialchars($item_details->item_name), 1);
    $pdf->Cell(30, 10, htmlspecialchars($item->quantity), 1);
    $pdf->Cell(30, 10, htmlspecialchars($item->price), 1);
    $pdf->Cell(30, 10, htmlspecialchars($item->weight), 1);
    $pdf->Ln();
}

// Output the PDF
$pdf->Output('I', 'invoice_' . $order_id . '.pdf');
?>
