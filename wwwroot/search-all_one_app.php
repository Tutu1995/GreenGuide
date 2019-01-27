<?php  
		include("db.php");
		//$s_location=htmlspecialchars($_GET["s_location"]);
		$s_company=htmlspecialchars($_GET["s_company"]);
        $s_status=1;
          try{
					//$con=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
					//$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  		/*
					if ($s_location && !($s_company)) {
						
						$rows=$db->prepare("select lng, lat, company, address, city, industry, product, AVG(rating) as avg_r, COUNT(id) as num_r from review where status=? and (address LIKE ? or city LIKE ?) GROUP BY lng,lat,company");					    
						$rows->execute(array($s_status, '%'.$s_location.'%', '%'.$s_location.'%'));
						
						$a=array();
						foreach ($rows as $row) {				  
							$a[]=$row;
						} 					    
					}
					
					if(!($s_location) && $s_company) {
						
						$coms=$db->prepare("select lng, lat, company, address, city, industry, product, AVG(rating) as avg_r, COUNT(id) as num_r from review where status=? and (company LIKE ? or industry LIKE ? or product LIKE ?) GROUP BY lng,lat,company");					    
						$coms->execute(array($s_status, '%'.$s_company.'%', '%'.$s_company.'%', '%'.$s_company.'%'));

						$a=array();
						foreach ($coms as $com) {				  
							$a[]=$com;
						} 		
					}*/

					if($s_company) {

						$comls=$db->prepare("select lng, lat, company, address, city, industry, product, AVG(rating) as avg_r, COUNT(id) as num_r from review where status=? and (company LIKE ? or industry LIKE ? or product LIKE ? or address LIKE ? or city LIKE ?) GROUP BY lng,lat,company");					    
						$comls->execute(array($s_status, '%'.$s_company.'%', '%'.$s_company.'%', '%'.$s_company.'%', '%'.$s_company.'%', '%'.$s_company.'%'));

						$a=array();
						foreach ($comls as $coml) {				  
							$a[]=$coml;
						} 		
					}


				$data = json_encode($a);
				echo $data;	
			  }
			  catch(Exception $e){
				  die(print_r($e));
			      //die("Sorry. Error occurred. Please try again.");
			  }
                   
  ?>