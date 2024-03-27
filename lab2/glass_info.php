<?php
require_once "vendor/autoload.php";

$glassId = isset($_GET['id']) ? $_GET['id'] : -1;
$db = new DbHandler();

if ($glassId == -1) {
  die("There is no Id defined");
}

$productType = "";
$price = "";
$productCode = "";
$productId = "";
$rating = "";
$image = "";

try {
  $db->connect();
  $glassInfo = $db->get_record_by_id((int) $glassId)[0];
  if (empty($glassInfo)) {
    die("No Item with this id $glassId is found");
  } else {
    $productType = $glassInfo->product_name;
    $price = $glassInfo->list_price;
    $productCode = $glassInfo->PRODUCT_code;
    $productId = $glassInfo->id;
    $rating = $glassInfo->Rating;
    $image = $glassInfo->Photo;

  }
} catch (Exception $e) {
  die("Error: " . $ex->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <table>
    <tr>
      <td>Type:
        <?php echo $productType ?>
      </td>
      <td>Price:
        <?php echo $price ?>
      </td>
    </tr>
    <tr>
      <td>
        Details:
        <br />
        code:
        <?php echo $productCode ?>
        <br />
        Item Id:
        <?php echo $productId ?>
        <br />
        Rating:
        <?php echo $rating ?>
      </td>
      <td>
        <img src="images/<?php echo $image ?>" alt="Glass Image" />
      </td>
    </tr>
  </table>
</body>

</html>