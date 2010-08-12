<?php
/**
 * Classes used to build HTML elements
 * 
 * @package library
 * @subpackage HTML
 */

/**
 * Build HTML Dropdowns
 * 
 * Options available onChange, onClick, name, default
 * @author Marco Ceppi <mceppi@danya.com>
 * @package library
 * @subpackage HTML
 */
class Dropdown
{
	private $html = "";
	
	/**
	 * Constructor
	 * 
	 * @param string $name Used for both name and ID of HTML Element
	 * @param array $options Accepts: style, size, onClick, onUpdate, onChance, onBlur, multiple
	 */
	function Dropdown($name, $options = NULL)
	{
		$this->html = "<SELECT ID=\"$name\" NAME=\"$name\" ";
		
		if( !is_null($options) )
		{
			foreach( $options as $command => $val )
			{
				switch( $command )
				{
					case 'multiple':
						$this->html .= "MULTIPLE ";
					break;
					default:
						$this->html .= "$command=\"$val\" ";
					break;
				}
			}
		}
		
		$this->html .= ">";
		
		return true;
	}
	
	/**
	 * Add entry into HTML Dropdown
	 * 
	 * @return boolean
	 * 
	 * @param string $name
	 * @param mixed $value
	 * @param array $options Available options are default, disabled
	 */
	function add($name, $value = NULL, $options = NULL)
	{
		$row = "<OPTION " . ((is_null($value)) ? "" : "VALUE=\"$value\" ");
		
		if( is_array($options) )
		{
			foreach( $options as $cmd => $val)
			{
				switch( $cmd )
				{
					case "default":
					case "disabled":
						$row .= "$cmd=$cmd ";
					break;
					default:
						$row .= "$cmd=\"$val\" ";
					break;
				}
			}
		}
		
		$row .= ">$name</OPTION>";
		$this->html .= $row;
		
		return true;
	}
	
	/**
	 * Return HTML output
	 * 
	 * @return string
	 */
	function build()
	{
		return $this->html . "</select>";
	}
}

/**
 * Build HTML Tables
 * 
 * @author Marco Ceppi <mceppi@danya.com>
 * @package library
 * @subpackage HTML
 */
class Table
{
	private $table = array();
	private $table_options;
	private $cur_row = 0;
	
	/**
	 * Constructor
	 * 
	 * @param array $options
	 */
	function Table( $options = NULL )
	{
		$this->table_options = ( is_array($options) ) ? $options : NULL;
	}
	
	/**
	 * Add a new "tr" and finish current cell additions
	 * 
	 * @return void
	 */
	function add_row()
	{
		$this->cur_row++;
	}
	
	/**
	 * Add a new cell (td) to the table
	 * 
	 * @param mixed $value The contents of the cell
	 * @param array $options Extra options. Accepts: rowspan, colspan, style, name, id, onClick, bgcolor
	 * 
	 * @return void
	 */
	function add_cell($value, $options = NULL)
	{
		$cell = array();
		$cell['value'] = $value;
		
		if( is_array($options) )
		{
			foreach( $options as $key => $val )
			{
				$cell[$key] = $val;
			}
		}
		
		$this->table[$this->cur_row][] = $cell;
	}
	
	/**
	 * Build the HTML table
	 * 
	 * @param string $nl What should be appended to each logical line end
	 * 
	 * @return string 
	 */
	function build( $nl = "" )
	{
		$output = "<table";
		
		// Loop through each table "option" and add it as an attribute to table
		if( is_array($this->table_options) )
		{
			foreach( $this->table_options as $key => $val )
			{
				$output .= " $key=\"$val\"";
			}
		}
		
		$output .= ">$nl";
		
		// Get each row
		foreach( $this->table as $row )
		{
			$output .= "<tr>$nl";
			
			// Loop through all the cells in a row
			foreach( $row as $cell )
			{
				$start = "<td";
				
				// Loop through each element of a row and append it as an attribute
				foreach( $cell as $key => $val )
				{
					if( $key == "value" )
					{
						$end = ">$val</td>$nl";
					}
					else
					{
						$start .= " $key=\"$val\"";
					}
				} // Cell attribute
				$output .= $start . $end;
			} // Cell
			$output .= "</tr>$nl";
		} // Row
		$output .= "</table>$nl";
		
		return $output;
	}
}

?>
