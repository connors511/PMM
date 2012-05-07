<?php

class Model_Io_Base
{

	function simplexml2array($xml)
	{
		if ($xml instanceof SimpleXMLElement)
		{
			$attributes = $xml->attributes();
			foreach ($attributes as $k => $v)
			{
				if ($v)
					$a[$k] = (string) $v;
			}
			$x = $xml;
			$xml = get_object_vars($xml);
		}
		if (is_array($xml))
		{
			if (count($xml) == 0)
				return (string) $x; // for CDATA
			foreach ($xml as $key => $value)
			{
				$r[$key] = $this->simplexml2array($value);
			}
			if (isset($a))
				$r['@attributes'] = $a;    // Attributes
			return $r;
		}
		return (string) $xml;
	}

}

?>
