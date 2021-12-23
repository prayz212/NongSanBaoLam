<?php

namespace App\Models;

class Cart {
	public $items = null;
	
	public function __construct($oldCart)
	{
		if($oldCart)
		{
			$this->items = $oldCart->items;
		}
	}
	
	public function add($item, $quantity)
	{
		$cart = ['qty' => (int)$quantity, 'item' => $item];
		if($this->items)
		{
			if(array_key_exists($item->id, $this->items))
			{
				$oldCart = $this->items[$item->id];
				$cart['qty'] += $oldCart['qty'];
			}
		}
		
		$this->items[$item->id] = $cart;
	}

	public function updateQuantity($id, $quantity) {
		$this->items[$id]['qty'] = $quantity;
	}

	public function deleteItem($id) {
		if($this->items)
		{
			if(array_key_exists($id, $this->items))
			{
				unset($this->items[$id]);
			}
		}
	}
}

?>