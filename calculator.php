<?php
//***************************
// BisonSoft 2017
//***************************

class Calculator
{
	public static function mod($num_A, $num_B, $num_verification = true)
	{
		if ($num_verification) { if (!self::valid_number($num_A) || !self::valid_number($num_B)) return 'E'; }
	
		if ($num_B == '0') return 'E';
		if ($num_A == '0') return '0';
		if ($num_B == '1') return '0';
		if ($num_A == $num_B) return '0';
		if (self::compare($num_A, $num_B, false) < 0) return $num_A;

		$buffer = '';
		$cnt_B = strlen($num_B); $d_pointer = 0;

		$buffer = substr($num_A, 0, $cnt_B); $d_pointer = $cnt_B;
		if (self::compare($num_B, $buffer, false) > 0) { $buffer .= $num_A[$d_pointer]; $d_pointer++; }

		$t_tab[1] = $num_B; for ($i = 2; $i <= 10; $i++) $t_tab[$i] = self::multip($num_B, (string)$i, false);

		while (true)
		{
			for ($i = 1; $i <= 10; $i++)
			{
				if (self::compare($buffer, $t_tab[$i], false) >= 0) continue;
				$buffer = self::diff($buffer, $t_tab[$i - 1], false);			
				break;
			}

			if (isset($num_A[$d_pointer]))
			{
				$buffer .= $num_A[$d_pointer];
				$d_pointer++;
			}
			else return $buffer;
		}
	}
	public static function div($num_A, $num_B, $precision = 10, $num_verification = true)
	{
		if ($num_verification) { if (!self::valid_number($num_A) || !self::valid_number($num_B)) return 'E'; }
	
		if ($num_B == '0') return 'E';
		if ($num_A == '0') return '0';
		if ($num_B == '1') return $num_A;
		if ($num_A == $num_B) return '1';

		$num_R = ''; $buffer = ''; $multiplier = 0;
		$cnt_A = strlen($num_A); $cnt_B = strlen($num_B); $cnt_R = 0; $d_pointer = 0; $dec_point = 0;

		if (self::compare($num_A, $num_B, false) < 0)
		{
			$multiplier = $cnt_B - $cnt_A;
			for ($i = 0; $i < $multiplier; $i++) $num_A .= '0';
			if (self::compare($num_A, $num_B, false) < 0) { $num_A .= '0'; $multiplier++; }
		}

		$buffer = substr($num_A, 0, $cnt_B); $d_pointer = $cnt_B;
		if (self::compare($num_B, $buffer, false) > 0) { $buffer .= $num_A[$d_pointer]; $d_pointer++; }
		if ($multiplier > $precision) return '0';

		$t_tab[1] = $num_B; for ($i = 2; $i <= 10; $i++) $t_tab[$i] = self::multip($num_B, (string)$i, false);

		while (true)
		{
			for ($i = 1; $i <= 10; $i++)
			{
				if (self::compare($buffer, $t_tab[$i], false) >= 0) continue;
				$num_R .= (string)($i - 1);
				$cnt_R++;
				$buffer = self::diff($buffer, $t_tab[$i - 1], false);			
				break;
			}

			if (isset($num_A[$d_pointer]))
			{
				$buffer .= $num_A[$d_pointer];
				$d_pointer++;
			}
			else
			{
				if ($buffer == '0')
				{
					if ($multiplier == 0) return $num_R;
					if ($multiplier >= $cnt_R)
					{
						$dec_point = 1 + $multiplier - $cnt_R;
						for ($i = 0; $i < $dec_point; $i++) $num_R = '0' . $num_R;
						return substr($num_R, 0, 1) . '.' . substr($num_R, 1);
					}
					else
					{
						$dec_point = $cnt_R - $multiplier;
						return substr($num_R, 0, $dec_point) . '.' . substr($num_R, $dec_point);
					}
				}
				else
				{
					if ($multiplier >= $precision)
					{
						if ($multiplier >= $cnt_R)
						{
							$dec_point = 1 + $multiplier - $cnt_R;
							for ($i = 0; $i < $dec_point; $i++) $num_R = '0' . $num_R;
							return substr($num_R, 0, 1) . '.' . substr($num_R, 1);
						}
						else
						{
							$dec_point = $cnt_R - $multiplier;
							return substr($num_R, 0, $dec_point) . '.' . substr($num_R, $dec_point);
						}
					}
					$buffer .= '0';
					$multiplier++;
				}
			}		
		}
	}
	public static function multip($num_A, $num_B, $num_verification = true)
	{
		if ($num_verification) { if (!self::valid_number($num_A) || !self::valid_number($num_B)) return 'E'; }
	
		if ($num_A == '1') return $num_B;
		if ($num_B == '1') return $num_A;
		if ($num_A == '0' || $num_B == '0') return '0';

		$num_R = '0'; $i_buffer = 0; $s_buffer = ''; $r_buffer = ''; $cb = 0;
		$cnt_A = strlen($num_A); $cnt_B = strlen($num_B);
		$num_A = strrev($num_A);

		for ($c = 0; $c < $cnt_B; $c++)
		{
			$cb = 0;
			for ($i = 0; $i < $cnt_A; $i++)
			{
				$i_buffer = $cb; $cb = 0;
				$i1 = (int)$num_A[$i];
				$i2 = (int)$num_B[$c];
				$i_buffer += $i1 * $i2;
				if ($i_buffer >= 10)
				{
					$s_buffer = (string)$i_buffer;
					$cb = (int)$s_buffer[0];
					$i_buffer = (int)$s_buffer[1];
				}
				$r_buffer .= (string)$i_buffer;
			}
			if ($cb > 0) $r_buffer .= (string)$cb;
			if ($c > 0) $num_R .= '0';
			$num_R = self::add($num_R, strrev($r_buffer), false);
			$r_buffer = '';
		}
		return $num_R;
	}
	public static function subtr($num_A, $num_B, $num_verification = true)
	{
		if ($num_verification) { if (!self::valid_number($num_A) || !self::valid_number($num_B)) return 'E'; }
	
		if ($num_B == '0') return $num_A;
		if ($num_A == '0') { $num_B = '-' . $num_B; return $num_B; }

		$num_R = ''; $buffer = ''; $cb = 0;
		$cnt_A = strlen($num_A); $cnt_B = strlen($num_B); $cnt_R = ($cnt_A >= $cnt_B) ? $cnt_A : $cnt_B;

		$signed_result = (self::compare($num_A, $num_B, false) < 0) ? true : false;
		if ($signed_result) { $buffer = $num_A; $num_A = $num_B; $num_B = $buffer; }
		$num_A = strrev($num_A); $num_B = strrev($num_B);

		for ($i = 0; $i < $cnt_R; $i++)
		{
			$i1 = (isset($num_A[$i])) ? (int)$num_A[$i] : 0;
			$i2 = (isset($num_B[$i])) ? (int)$num_B[$i] : 0;
			$i2 += $cb; $cb = 0;

			if ($i1 >= $i2) $buffer = $i1 - $i2; else { $buffer = ($i1 + 10) - $i2; $cb = 1; }
			$num_R .= (string)$buffer;
		}

		$num_R = strrev($num_R);
		$num_R = ltrim($num_R, '0');
		if ($signed_result) $num_R = '-' . $num_R;
		return ($num_R == '') ? '0' : $num_R;
	}
	public static function diff($num_A, $num_B, $num_verification = true)
	{
		if ($num_verification) { if (!self::valid_number($num_A) || !self::valid_number($num_B)) return 'E'; }
	
		if ($num_A == '0') return $num_B;
		if ($num_B == '0') return $num_A;

		$num_R = ''; $buffer = ''; $cb = 0;
		$cnt_A = strlen($num_A); $cnt_B = strlen($num_B); $cnt_R = ($cnt_A >= $cnt_B) ? $cnt_A : $cnt_B;

		if (self::compare($num_A, $num_B, false) < 0) { $buffer = $num_A; $num_A = $num_B; $num_B = $buffer; }
		$num_A = strrev($num_A); $num_B = strrev($num_B);

		for ($i = 0; $i < $cnt_R; $i++)
		{
			$i1 = (isset($num_A[$i])) ? (int)$num_A[$i] : 0;
			$i2 = (isset($num_B[$i])) ? (int)$num_B[$i] : 0;
			$i2 += $cb; $cb = 0;

			if ($i1 >= $i2) $buffer = $i1 - $i2; else { $buffer = ($i1 + 10) - $i2; $cb = 1; }
			$num_R .= (string)$buffer;
		}

		$num_R = strrev($num_R);
		$num_R = ltrim($num_R, '0');
		return ($num_R == '') ? '0' : $num_R;
	}
	public static function add($num_A, $num_B, $num_verification = true)
	{
		if ($num_verification) { if (!self::valid_number($num_A) || !self::valid_number($num_B)) return 'E'; }
	
		if ($num_A == '0') return $num_B;
		if ($num_B == '0') return $num_A;

		$num_R = ''; $buffer = ''; $cb = 0;
		$cnt_A = strlen($num_A); $cnt_B = strlen($num_B); $cnt_R = ($cnt_A >= $cnt_B) ? $cnt_A : $cnt_B;
		$num_A = strrev($num_A); $num_B = strrev($num_B);

		for ($i = 0; $i < $cnt_R; $i++)
		{
			$buffer = $cb; $cb = 0;
			$i1 = (isset($num_A[$i])) ? (int)$num_A[$i] : 0;
			$i2 = (isset($num_B[$i])) ? (int)$num_B[$i] : 0;

			$buffer += $i1 + $i2;
			if ($buffer >= 10) { $buffer -= 10; $cb = 1; }
			$num_R .= (string)$buffer;
		}

		if ($cb > 0) $num_R .= (string)$cb;
		$num_R = strrev($num_R);
		return $num_R;
	}
	public static function compare($num_A, $num_B, $num_verification = true)
	{
		if ($num_verification) { if (!self::valid_number($num_A) || !self::valid_number($num_B)) return 'E'; }
	
		if ($num_A == $num_B) return 0;

		$cnt_A = strlen($num_A); $cnt_B = strlen($num_B);
		if ($cnt_A != $cnt_B) return ($cnt_A > $cnt_B) ? 1 : -1;

		for ($i = 0; $i < $cnt_A; $i++)
		{
			$i1 = (int)$num_A[$i];
			$i2 = (int)$num_B[$i];
			if ($i1 == $i2) continue;
			return ($i1 > $i2) ? 1 : -1;
		}
		return 0;
	}
	public static function valid_number(&$number)
	{
		$buffer = ltrim($number,'0'); $number = ($buffer == '') ? '0' : $buffer;
		return (ctype_digit($number)) ? true : false;
	}
}
?>