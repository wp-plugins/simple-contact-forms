<?php 

class scf_Form_List_Table extends WP_List_Table {

	private $options;

   /**
    * Constructor, we override the parent to pass our own arguments
    * We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
    */
    function __construct() {
       parent::__construct( array(
	      'singular'=> 'wp_list_text_link', //Singular label
	      'plural' => 'wp_list_test_links', //plural label, also this well be one of the table css class
	      'ajax'   => false //We won't support Ajax for this table
      ) );
    }

    /**
	 * Add extra markup in the toolbars before or after the list
	 * @param string $which, helps you decide if you add the markup after (bottom) or before (top) the list
	 */
	function extra_tablenav( $which ) {
	   if ( $which == "top" ){
	      //The code that goes before the table is here
	      //echo"Hello, I'm before the table";
	   }
	   if ( $which == "bottom" ){
	      //The code that goes after the table is there
	      //echo"Hi, I'm after the table";
	   }
	}

	/**
	 * Define the columns that are going to be used in the table
	 * @return array $columns, the array of columns to use with the table
	 */
	function get_columns() {
	   return $columns= array(
	      'col_link_id'=>__('Order'),
	      'col_link_label'=>__('Label'),
	      'col_link_type'=>__('Type'),
	      'col_link_options'=>__('Options'),
	      'col_link_required'=>__('Required'),
	      'col_link_exclude'=>__('Exclude'),
	      'col_link_is_delete'=>__(''),
	   );
	}

	/**
	 * Decide which columns to activate the sorting functionality on
	 * @return array $sortable, the array of columns that can be sorted by the user
	 */
	public function get_sortable_columns() {
		return $sortable = array(

  		);
	}

	/**
	 * Prepare the table with different parameters, pagination, columns and table elements
	 */
	function prepare_items_original() {
	   global $wpdb, $_wp_column_headers;
	   $screen = get_current_screen();

	   /* -- Preparing your query -- */
	        $query = "SELECT * FROM $wpdb->links";

	   /* -- Ordering parameters -- */
	       //Parameters that are going to be used to order the result
	       $orderby = !empty($_GET["orderby"]) ? mysql_real_escape_string($_GET["orderby"]) : 'ASC';
	       $order = !empty($_GET["order"]) ? mysql_real_escape_string($_GET["order"]) : '';
	       if(!empty($orderby) & !empty($order)){ $query.=' ORDER BY '.$orderby.' '.$order; }

	   /* -- Pagination parameters -- */
	        //Number of elements in your table?
	        $totalitems = $wpdb->query($query); //return the total number of affected rows
	        //How many to display per page?
	        $perpage = 5;
	        //Which page is this?
	        $paged = !empty($_GET["paged"]) ? mysql_real_escape_string($_GET["paged"]) : '';
	        //Page Number
	        if(empty($paged) || !is_numeric($paged) || $paged<=0 ){ $paged=1; }
	        //How many pages do we have in total?
	        $totalpages = ceil($totalitems/$perpage);
	        //adjust the query to take pagination into account
	       if(!empty($paged) && !empty($perpage)){
	          $offset=($paged-1)*$perpage;
	         $query.=' LIMIT '.(int)$offset.','.(int)$perpage;
	       }

	   /* -- Register the pagination -- */
	      $this->set_pagination_args( array(
	         "total_items" => $totalitems,
	         "total_pages" => $totalpages,
	         "per_page" => $perpage,
	      ) );
	      //The pagination links are automatically built according to those parameters

	   /* -- Register the Columns -- */
	      $columns = $this->get_columns();
	      $_wp_column_headers[$screen->id]=$columns;

	   /* -- Fetch the items -- */
	      $this->items = $wpdb->get_results($query);
	}


	/**
	 * Set the options
	 */
	public function setPassedOptions($vals) {

		// Set the options
		$this->options = ($vals ? $vals : array());

	}


	/**
	 * Prepare the table with different parameters, pagination, columns and table elements
	 */
	function prepare_items() {
	   global $wpdb, $_wp_column_headers;
	   $screen = get_current_screen();

	   /* -- Ordering parameters -- */
	       //Parameters that are going to be used to order the result
	       $orderby = !empty($_GET["orderby"]) ? mysql_real_escape_string($_GET["orderby"]) : 'ASC';
	       $order = !empty($_GET["order"]) ? mysql_real_escape_string($_GET["order"]) : '';
	       if(!empty($orderby) & !empty($order)){ $query.=' ORDER BY '.$orderby.' '.$order; }

	   /* -- Register the Columns -- */
	      $columns = $this->get_columns();
		  $hidden = array();
		  $sortable = $this->get_sortable_columns();
		  $this->_column_headers = array($columns, $hidden, $sortable);

	   /* -- Fetch the items -- */
	  		$data = $this->options;
	   		if( !empty($data['fields']) ) {
				$this->items .= '<script type="text/javascript">';
					$js_array = json_encode($data['fields']);
					$this->items .= "var fields_arr = ". $js_array . ";\n";
				$this->items .= '</script>';
			};
	}

	/**
	 * Display the rows of records in the table
	 * @return string, echo the markup of the rows
	 */
	function display_rows() {
		echo $this->items;
	}

}