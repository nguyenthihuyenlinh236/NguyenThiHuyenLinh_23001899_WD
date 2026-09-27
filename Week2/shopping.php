<?php
class CartItem{
    private $name;
    private $price;
    private $quantity;
    public function __construct($name, $price, $quantity)
    {
        if (empty(trim($name))){
            throw new Exception("Ten san pham khong hop le.");
        }
        if (!is_numeric($price) || $price <= 0){
            throw new Exception("Gia san pham phai lon hon 0.");
        }
        if (!is_numeric($quantity) || $quantity <= 0){
            throw new Exception("So luong san pham phai lon hon 0.");
        }
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }
    public function getName(){
        return $this->name;
    }
    public function getPrice(){
        return $this->price;
    }
    public function getQuantity(){
        return $this->quantity;
    }
    public function getTotal(){
        return $this->price*$this->quantity;
    }
}
class ShoppingCart{
    private $items=[];
    public function getItem(){
        return $this->items;
    }
    public function addItem($item){
        if($item->price>0 && $item->quantity>0)
            array_push($this->items,$item);
    }
    public function removeItem($name){
        $found = false;
        foreach ($this->items as $key=>$item){
            if ($item->name === $name){
                unset($this->items[$key]);
                $found = true;
                break;
            }
        }
        if (!$found){
            echo "Khong tim thay san pham.";
        }
    }
    public function calculateTotal(){
        $total = 0;
        foreach ($this->items as $item){
            $total += $item->getTotal();
        }
        return $total;
    }
    public function displayCart(){
        echo "Gio hang:" . "<br>";
        foreach ($this->items as $item){
            echo "Ten san pham: " . $item->name . "<br>";
            echo "Don gia: " . $item->price . "<br>";
            echo "So luong: " . $item->quantity . "<br>";
            echo "<br>";
        }
    }
}
$cart1 = new ShoppingCart();
$item1 = new CartItem("pen",10000,2);
$item2 = new CartItem("pencil",5000,2);
$item3 = new CartItem("book",20000,2);
$item4 = new CartItem("ruler",3000,2);
$cart1->addItem($item1);
$cart1->addItem($item2);
$cart1->addItem($item3);
$cart1->addItem($item4);
$cart1->displayCart();
echo "Tong so tien: " . $cart1->calculateTotal() . "<br>";
echo "<br>";
$cart1->removeItem("pen");
$cart1->displayCart();
?>