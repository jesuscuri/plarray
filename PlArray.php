<?php
class PlArray {
	protected $arr;
	protected $_length;
	public function __construct ($arr) {
		if ($arr instanceof PlArray)
			$this->wrap($arr->getArray());
		else {
			$this->wrap($arr);
		}
	}

	protected function getArray() {
		return $this->arr;
	}
	public function getAll() {
		$turn = [];
		foreach ($this->arr as $k => $v) {
			$turn[$k] = $v;
		}
		return $turn;
	}

	public function wrap($arr) {
		$this->arr = $arr;
		$this->recount();
	}

	public function length() {
		return $this->_length;
	}

	protected function recount() {
		$this->_length = count($this->arr);
	}

	public function _each($funct) {
		foreach ($this->arr as $k => $v) {
			$funct ($k, $v);
		}
		return $this;
	}

	public function merge ($plarray) {
		$arr = $plarray;
		if ($plarray instanceof PlArray)
			$arr = $plarray->getArray();
		$this->arr = array_merge($this->arr, $arr);
		$this->recount();
		return $this->arr;
	}

	public function get($index) {
		return $this->arr[$index];
	}

	public function indexes() {
		$turn = [];
		foreach ($this->arr as $k => $v) {
			$turn[] = $k;
		}
		return new PlArray($turn);
	}

	public function indexOf($value, $strict = false) {
		return array_search($value, $this->arr, $strict);
	}

	public function del ($index) {
		if (isset($this->arr[$index]))
			unset($this->arr[$index]);
		$this->recount();
	}

	public function splice ($index, $amount) {
		$turn = array_splice($this->arr, $index, $amount);
		$this->recount();
		return $turn;
	}

	public function push($value) {
		$this->arr[] = $value;
		$this->recount();
	}

	public function attach($str) {
		$k = "";
		$j = 0;
		foreach ($this->arr as $i => $v) {
			$k .= $v . ($j == count($this->arr) - 1 ? "" : $str);
			$j++;
		}
		return $k;
	}

	public function map($funct) {
		$turn = [];
		foreach ($this->arr as $k => $v) {
			$turn[] = $funct($k, $v);
		}
		return new PlArray($turn);
	}

}
