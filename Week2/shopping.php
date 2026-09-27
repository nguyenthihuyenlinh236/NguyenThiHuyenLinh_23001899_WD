<?php
class CartItem
{
    private $name;
    private $price;
    private $quantity;
    public function __construct($name, $price, $quantity)
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }
    public function getTotal()
    {
        return $this->price * $this->quantity;
    }
}
class ShoppingCart
{
    private $items = [];
    public function getItems()
    {
        return $this->items;
    }
    public function addItem($item)
    {
        if ($item === null || $item->getPrice() <= 0 || $item->getQuantity() <= 0) {
            return false;
        }
        $this->items[] = $item;
        return true;
    }
    public function removeItem($name)
    {
        foreach ($this->getItems() as $key => $item) {
            if ($item->getName() === $name) {
                unset($this->items[$key]);
                $this->items = array_values($this->items);
                return true;
            }
        }
        return false;
    }
    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getTotal();
        }
        return $total;
    }
    public function displayCart()
    {
        echo "Gio hang:" . "<br>";
        foreach ($this->items as $item) {
            echo "Ten san pham: " . $item->getName() . "<br>";
            echo "Don gia: " . $item->getPrice() . "<br>";
            echo "So luong: " . $item->getQuantity() . "<br>";
            echo "<br>";
        }
    }
}
function createCartItem($name, $price, $quantity)
{
    if (trim($name) === "" || $price <= 0 || $quantity <= 0) {
        return null;
    }
    return new CartItem($name, $price, $quantity);
}
function handleAddItem($items, $item)
{
    if ($items->addItem($item)) {
        echo "Them vao gio hang thanh cong." . "<br>";
    } else {
        echo "Them vao gio hang that bai." . "<br>";
    }
}
function handleRemoveItem($items, $item)
{
    if ($items->removeItem($item)) {
        echo "Xoa khoi gio hang thanh cong." . "<br>";
    } else {
        echo "Xoa khoi gio hang that bai." . "<br>";
    }
}
$cart1 = new ShoppingCart();

$item1 = createCartItem("pen", 10000, 2);
$item2 = createCartItem("pencil", 5000, 2);
$item3 = createCartItem("book", 20000, 2);
$item4 = createCartItem("ruler", 3000, 2);

handleAddItem($cart1, $item1);
handleAddItem($cart1, $item2);
handleAddItem($cart1, $item3);
handleAddItem($cart1, $item4);

$cart1->displayCart();
echo "Tong so tien: " . $cart1->calculateTotal() . "<br>";
echo "<br>";
handleRemoveItem($cart1, "pen");
$cart1->displayCart();
