// console.log("krepselis.js initialized");

// Math.round apvalina iki sveiko skaičiaus, tad norėdami gauti trumpmeninę dalį 2 šimtųjų tikslumu:
// dauginame iš 100 apvalinamą reikšmę ir suapvalintą rezultatą daliname iš 100
function round2(x) {
	return Math.round(x * 100) / 100;
}

class Cart {
	constructor() {
		this.itemCount = 0;
		this.item = [];
		// alert(this.price);
	}

	addItem(element, id, name, price, /*count,*/ unit) {
		let count = element.children[0].children[0].children[1].value;
		if (this.upadateItem(id, count) == false) {
			this.item[this.itemCount] = new Item(id, name, price, count, unit);
			this.itemCount++;
		}
		this.displayAllItems();
		setCookie("krepselis", JSON.stringify(cart), 7);
	}

	upadateItem(id, count) {
		for (let i = 0; i < this.itemCount; i++) {
			if (this.item[i].id == id) {
				this.item[i].count = parseFloat(this.item[i].count) + parseFloat(count);
				this.item[i].combinedPrice = round2(
					this.item[i].price * this.item[i].count
				);
				this.displayAllItems();
				setCookie("krepselis", JSON.stringify(cart), 7);
				return true;
			}
		}
		return false;
	}

	changeCount(id, count) {
		for (let i = 0; i < this.itemCount; i++) {
			if (this.item[i].id == id) {
				this.item[i].count = count;
				this.item[i].combinedPrice = round2(this.item[i].price * this.item[i].count);
				this.displayAllItems();
				setCookie("krepselis", JSON.stringify(cart), 7);
			}
		}
	}

	removeItem(id) {
		let index = -1;
		for (let i = 0; i < this.itemCount; i++) {
			if (this.item[i].id == id) {
				index = i;
			}
		}
		if (index > -1) {
			this.item.splice(index, 1);
			this.itemCount--;
		}
		this.displayAllItems();
		setCookie("krepselis", JSON.stringify(cart), 7);
	}

	displayAllItems() {
		let target = document.getElementById("krepselio-turinys");
		target.innerHTML="";
		for (let i = 0; i < this.itemCount; i++) {
			// console.log(this.item[i].name + " " + this.item[i].combinedPrice);
			let productInfo = document.createElement("div"); // sukuriamas <div> elementas
			productInfo.innerHTML = this.item[i].name + " <input class=\"input\" type=\"number\" min=\"1\" value=\"" + this.item[i].count + "\" style=\"width:40px\" onchange=\"cart.changeCount(" + this.item[i].id + ", this.value)\"> " + this.item[i].unit + " " + this.item[i].combinedPrice +"€<img src=\"img/close.svg\" width=\"18\" height=\"18\" onclick=\"cart.removeItem(" + this.item[i].id + ");\">"; // sukurtas <div> elementas užpildomas turiniu
			target.appendChild(productInfo); // elementas prijungiamas prie taikinio
		}
		let totalPrice = document.createElement("div");
		totalPrice.innerHTML = "<b>Bendra produktų kaina: " + this.totalPrice() + "€</b>";
		target.appendChild(totalPrice);
	}

	totalPrice() {
		let price = 0;
		for (let i = 0; i < this.itemCount; i++) {
			price += this.item[i].combinedPrice;
		}
		return price.toFixed(2);
	}
}

class Item {
	constructor(id, name, price, count, unit) {
		this.id = id;
		this.name = name;
		this.price = price;
		this.count = count;
		this.unit = unit;
		this.combinedPrice = round2(this.price * this.count);
	}
}

function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
	var expires = "expires=" + d.toUTCString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(";");
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == " ") {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}

var cart = new Cart();
window.onload = function krepselis() { 
	let storedCart = getCookie("krepselis");
	if (storedCart != null && storedCart != "") {
		storedCart = JSON.parse(storedCart);

		cart.itemCount = storedCart.itemCount;
		for (let i = 0; i < storedCart.itemCount; i++) {
			cart.item[i] = new Item(
				storedCart.item[i].id,
				storedCart.item[i].name,
				storedCart.item[i].price,
				storedCart.item[i].count,
				storedCart.item[i].unit
			);
		}
		cart.displayAllItems();
	}
}