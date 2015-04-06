<?php
function prepare($queri)
	{	$queri=trim($queri);
		$i=strlen($queri);
        if(substr($queri,0,1)!=".")
        {
		if($i>0) 
		{	$a_fec=explode("^",$queri);
			if(count($a_fec)>1)
			{	$queri=" ";
				foreach($a_fec as $key => $val) 
				{	if(strlen($val)>0)
						$queri=$queri." contengases ILIKE '%".$val."%' or";
				}
				$queri=substr($queri,1,-2)." ";
			}
			else
			{	$a_fec=explode(":",$queri);
				if(count($a_fec)>1)
				{	$queri=" BETWEEN '";
					foreach($a_fec as $key => $val)
					{	$queri=$queri.$val."' AND '";
					}
					$queri=substr($queri,1,-5)." ";
				}
				else
				{	$a_fec=explode("?",$queri);
					if(count($a_fec)>1)
					{	$queri=" ";
						foreach($a_fec as $key => $val) 
						{	if(strlen($val)>0)
								$queri=$queri." contengases ILIKE '%".$val."' or";
						}
						$queri=substr($queri,1,-2)." ";
					}
					else
					{	$a_fec=explode("!",$queri);
						if(count($a_fec)>1)
						{	$queri=" ";
							foreach($a_fec as $key => $val) 
							{	if(strlen($val)>0)
									$queri=$queri." contengases ILIKE '".$val."%' or";
							}
							$queri=substr($queri,1,-2)." ";
						}
						else
						{	$a_fec=explode("|",$queri);
							if(count($a_fec)>1)
							{	$queri=" in (";
								foreach($a_fec as $key => $val) 
								{	if(strlen($val)>0)
										$queri=$queri."'".$val."',";
								}
								$queri=substr($queri,1,-1).")";
							}
							else
							{	$a_fec=explode("~",$queri);
								if(count($a_fec)>1)
								{	$queri=" not in (";
									foreach($a_fec as $key => $val) 
									{	if(strlen($val)>0)
											$queri=$queri."'".$val."',";
									}
									$queri=substr($queri,1,-1).")";
								}
								else
								{	$p=strlen($queri);
									$j=0;
									for($i=0; $i<$p; $i++)
									{	if($queri{$i} == "*") 
										{	$j=1;
											$queri=" ILIKE '".substr($queri,0,$i)."%".substr($queri,$i+1,$p)."'";
											$queri=ereg_replace("\*","%",$queri);
										}
										else
										{	if(($queri{$i} == ">") || ($queri{$i} == "<"))
											{	if(($queri{$i+1} == "=") || ($queri{$i+1} == "="))
												{	$j=1;
													$queri=substr($queri,0,2)."'".trim(substr($queri,$i+2,$p))."'";
													break;
												}
												else
												{	if((($queri{$i+1} == ">") || ($queri{$i+1} == "<")))
													{	$j=0;
														//$queri=substr($queri,0,1)."'".trim(substr($queri,$i+1,$p))."'";
														break;
													}
													else
													{	$j=1;
														$queri=substr($queri,0,1)."'".trim(substr($queri,$i+1,$p))."'";
														break;
													}
												}
											}
										}
									}
									if($j==0)
									{	if(substr($queri,0,1)!=".")
										$queri="='".$queri."'";
									}
								}
							}
						}
					}
				}
			}
		}
        }
		return $queri;
	}
?>
