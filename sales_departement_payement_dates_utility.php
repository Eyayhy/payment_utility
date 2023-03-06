#!/usr/bin/env php
<?php 

/**
 * 
 * 
 * 
 *************Calculate the Payment dates****************
 *
 * 
 * 
 **/

for ($i = date('n'); $i <= 12; $i++) // loop the months of the year
{
  $monthName = date('F', mktime(0, 0, 0, $i, 1)); // Get the month name

// Get the fixed base salary payment date

$lastDayMonth = date('t', mktime(0, 0, 0, $i, 1));
$fixedBaseSalaryPaymentDate = date('Y-m-d', mktime(0, 0, 0, $i, $lastDayMonth, date('Y')));
if (date('N', strtotime($fixedBaseSalaryPaymentDate)) >= 6)
{
    $fixedBaseSalaryPaymentDate = date('Y-m-d', strtotime('last friday of ' . $monthName . ' ' . date('Y')));
}

// Get the bonus payment date

$bonusPaymentDate = date('Y-m-15', mktime(0, 0, 0, $i, 1, date('Y')));
if (date('N', strtotime($bonusPaymentDate)) >= 6)
{
    $bonusPaymentDate = date('Y-m-d', strtotime('next wednesday', strtotime('first day of next month')));
}
$payment_dates[] = array($monthName, $fixedBaseSalaryPaymentDate, $bonusPaymentDate);  // Define an array to contain the payment dates 
}

/**
 * 
 * 
 * 
 *************Creating the CSV Output File for the payment dates ****************
 *
 * 
 * 
 **/

 // Define the header for the CSV file
$header_csv = array('Month Name','Salary Payment Date','Bonus Payment Date');

// Build the CSV file 

 $payment_file = fopen('sales_departement_payment_dates.csv', 'w');
 fputcsv($payment_file, $header_csv ,';');
 foreach ($payment_dates as $payment_date)
  {
     fputcsv($payment_file, $payment_date,';');
  }
 fclose($payment_file);
 echo "Payment Dates CSV file has been created successfully\n";

?>

