<?php
// Read the contents of the data.json file
$data = file_get_contents('data.json');

// Decode the JSON data into an associative array
$dataArray = json_decode($data, true);

// Check if the data and data array exist
if ($data && $dataArray && isset($_POST['id'])) {
     $expenseId = $_POST['id'];

     // Search for the expense with the specified ID
     $expenseIndex = -1;
     foreach ($dataArray['data'] as $index => $expense) {
          if ($expense['id'] == $expenseId) {
               $expenseIndex = $index;
               break;
          }
     }

     // If the expense is found, remove it from the data array
     if ($expenseIndex !== -1) {
          $deletedExpense = $dataArray['data'][$expenseIndex];
          $deletedAmount = $deletedExpense['amount'];

          // Remove the expense from the data array
          array_splice($dataArray['data'], $expenseIndex, 1);

          // Update the account balance and used balance
          if ($deletedExpense['type'] === 'card' || $deletedExpense['type'] === 'cash') {
               $dataArray['account_balance'] += $deletedAmount;
               $dataArray['used'] -= $deletedAmount;
          } else if ($deletedExpense['type'] === 'income') {
               $dataArray['account_balance'] -= $deletedAmount;
          }

          // Save the updated data to the data.json file
          file_put_contents('data.json', json_encode($dataArray));

          // Return a success response with the deleted expense details
          $response = array(
               'success' => true,
               'deletedExpense' => $deletedExpense
          );
          echo json_encode($response);
          exit;
     }
}

// If the deletion was unsuccessful, return an error response
$response = array(
     'success' => false
);
echo json_encode($response);
