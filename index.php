<?php session_start();error_reporting(E_ALL^E_NOTICE);?>
<html>
    <head>
        <title>Search Estates</title>
        <style type="text/css">
            h1,p {text-align: center}
            .search{
                width:400px;
                margin:0px auto auto 500px;
                
            }
            form {
                border:1px;
            }
            
            .result{text-align:left}
            table 
            {   
                margin:auto;
                text-align:center;
            }
            td{
                width:200px;
            }
            .first{text-align:left;width:220px}
            .second{text-align:left;width:120px}
            .third{text-align:left;width:350px;}
            .fourth{text-align:right;width:150px;}
            }
            
            
        </style>
        <script type="text/javascript">
            function checkEmpty(fm)
            {
                var info="";
                var num=0;
                if(fm.street.value==""||fm.city.value=="")
                {
                    if(fm.street.value=="")
                    {
                        if(num==0)
                        {
                            info+="Street";
                            num=1;
                        }
                    }
                    if(fm.city.value=="")
                    {
                        if(num==0)
                            info+="City";
                        else
                        {
                            info+=" and City";
                        }
                    }
                    alert("Please enter value for "+info+".");
                    
                    location.reload();
        
                    return false;
                }
                else 
                    return true;
            }
        </script>
    </head>
    <body>
        
        <h1>
            Real Estate Search
        </h1>
        <div class="search" style="border-style:solid;border-color:black;border-width:3px;"> 
        <form name="form" action="" method="GET">
            &nbsp&nbsp&nbsp Street Address*:<input type="text" name="street" value="<%=request("street")%>"/>
            <br/>
            &nbsp&nbsp&nbsp City*:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text" name="city" value=<?php echo $_GET['city']?> />
            <br/>
            &nbsp&nbsp&nbsp State*:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<select name="state" size="1" value="<%=request("state")%>">
                        <option value="AK">AK</option>

                        <option value="AL">AL</option>
                        <option value="AR">AR</option>
                        <option value="AZ">AZ</option>
                        <option value="CA" selected>CA</option>

                        <option value="CO">CO</option>
                        <option value="CT">CT</option>
                        <option value="DC">DC</option>
                        <option value="DE">DE</option>

                        <option value="FL">FL</option>
                        <option value="GA">GA</option>
                        <option value="HI">HI</option>
                        <option value="IA">IA</option>

                        <option value="ID">ID</option>
                        <option value="IL">IL</option>
                        <option value="IN">IN</option>
                        <option value="KS">KS</option>

                        <option value="KY">KY</option>
                        <option value="LA">LA</option>
                        <option value="MA">MA</option>
                        <option value="MD">MD</option>

                        <option value="ME">ME</option>
                        <option value="MI">MI</option>
                        <option value="MN">MN</option>
                        <option value="MO">MO</option>

                        <option value="MS">MS</option>
                        <option value="MT">MT</option>
                        <option value="NC">NC</option>
                        <option value="ND">ND</option>

                        <option value="NE">NE</option>
                        <option value="NH">NH</option>
                        <option value="NJ">NJ</option>
                        <option value="NM">NM</option>

                        <option value="NV">NV</option>
                        <option value="NY">NY</option>
                        <option value="OH">OH</option>
                        <option value="OK">OK</option>

                        <option value="OR">OR</option>
                        <option value="PA">PA</option>
                        <option value="RI">RI</option>
                        <option value="SC">SC</option>

                        <option value="SD">SD</option>
                        <option value="TN">TN</option>
                        <option value="TX">TX</option>
                        <option value="UT">UT</option>

                        <option value="VA">VA</option>
                        <option value="VT">VT</option>
                        <option value="WA">WA</option>
                        <option value="WI">WI</option>

                        <option value="WV">WV</option>
                        <option value="WY">WY</option>
                    </select>
            </br>
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="submit" name="search" value="search" onClick="return checkEmpty(this.form);"/>
            
            </br>
            <i>&nbsp&nbsp&nbsp *-Mandatory fields.</i>
        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<img src="http://www.zillow.com/widgets/GetVersionedResource.htm?path=/static/logos/Zillowlogo_150x40_rounded.gif" width="150" height="40" alt="Zillow Real Estate Search" />
       
        </form>
    </div>
        
        <?php
        if($_SESSION["wrong"]==1)
        {
            echo "<p><b>No exact match found--Verify that the given address is correct.</b></p>";
            $_SESSION["wrong"]=0;
        }
        ?>




        <?php if(isset($_GET["search"])):?>  



        
        <?php $url=array("zws-id"=>"X1-ZWz1dxj6tnxi4r_6msnx",
                          "address"=>$_GET['street'],
                            "citystatezip"=>$_GET['city'].", ".$_GET['state'],
                                "rentzestimate"=>"true");
              $url="http://www.zillow.com/webservice/GetDeepSearchResults.htm?".http_build_query($url);
        
        
        $xml = simplexml_load_file($url);

        $_SESSION["wrong"]=0;
       
       
        if($xml->message->code=='508')
        {
            $_SESSION["wrong"]=1;
            $urll= $_SERVER['PHP_SELF'];
            echo "<script type='text/javascript'>";   
            echo "window.location.href='$urll'";   
            echo "</script>";    
        }

        ?>

        </br>


        <h1> 
            Search Results
        </h1>
        <?php $detailurl=$GLOBALS['xml']->response->results->result->links->homedetails; ?>
        <?php $detaild=$GLOBALS['xml']->response->results->result->address->street.", ".$GLOBALS['xml']->response->results->result->address->city.", ".$GLOBALS['xml']->response->results->result->address->state."-".$GLOBALS['xml']->response->results->result->address->zipcode; ?>
        <div class="result" style="border-color:#000;border-width:1px;border-style:solid;background:rgb(241,233,196);width:850px;height:50px;margin:auto"><p>See more details for <a href="<?php echo $detailurl ?>"><?php echo $detaild ?></a> on Zillow</p></div>
        
        <table>
            <tr>
                <td class="first">Property Type:</td>
                <?php $var11=$GLOBALS['xml']->response->results->result->useCode ?>
                <td class="second"><?php if($var11==""):?>N/A</td><?php else: echo $var11; ?></td><?php endif;?>
                <td class="third">Last Sold Price:</td>
                <?php $var12=$GLOBALS['xml']->response->results->result->lastSoldPrice;?>
                <td class="fourth"><?php if($var12==""):?>N/A</td> <?php else: echo "$".number_format(floatval($var12),2,".",","); ?></td><?php endif;?>
            </tr>
            <tr>
                <td class="first">Year Built:</td>
                <?php $var21=$GLOBALS['xml']->response->results->result->yearBuilt;?>
                <td class="second"><?php if($var21==""):?>N/A</td><?php else: echo $var21?></td><?php endif;?>
                <td class="third">Last Sold Date:</td>
                <?php $a=$GLOBALS['xml']->response->results->result->lastSoldDate;?>
                <td class="fourth"><?php date_default_timezone_set('PRC');
                                    $d=strtotime("$a");                              
                                    if($a==""):?>N/A</td>
                                    <?php else: echo date("d-M-Y",$d);?></td><?php endif;?>
            </tr>
            <tr>
                <td class="first">Lot Size:</td>
                <?php $var31=$GLOBALS['xml']->response->results->result->lotSizeSqFt;?>
                <td class="second"><?php if($var31==""):?>N/A</td><?php else: echo number_format(floatval($var31),0,".",",")." sq. ft"?></td><?php endif;?>
                <?php $var32=$GLOBALS['xml']->response->results->result->zestimate->children()[1];?>
                <td class="third">Zestimate<sup>&#174;</sup> Property Estimate<?php date_default_timezone_set('PRC'); 
                                                                    $d=strtotime("$var32");
                                                                    if($var32==""):?>:</td>
                                                                    <?php else:
                                                                    echo " as of ".date("d-M-Y",$d); ?>:</td><?php endif;?>
                <?php $var33=$GLOBALS['xml']->response->results->result->zestimate->amount?>
                <td class="fourth"><?php if($var33==""):?>N/A</td><?php else: echo "$".number_format(floatval($var33),2,".",",")?></td><?php endif;?>
            </tr>
            <tr>
                <td class="first">Finished Area:</td>
                <?php $var42=$GLOBALS['xml']->response->results->result->finishedSqFt?>
                <td class="second"><?php if($var42==""):?>N/A</td><?php else: echo number_format(floatval($var42),0,".",",")." sq. ft"?></td><?php endif;?>
                <?php $change=$GLOBALS['xml']->response->results->result->zestimate->valueChange?>
                <td class="third">30 Days Overall Change<?php if($change==""):?>
                                        
                                                        <?php elseif($change<0): $change=-$change; ?>
                                                            <img src="http://cs-server.usc.edu:45678/hw/hw6/down_r.gif">
                                                        <?php elseif($change>=0): ?>
                                                             <img src="http://cs-server.usc.edu:45678/hw/hw6/up_g.gif">  
                                                        <?php endif; ?>:</td>
                <td class="fourth"><?php if($change==""):?>N/A</td>
                                        <?php else: echo "$".number_format(floatval($change),2,".",",")?></td><?php endif;?>
            </tr>
            <tr>
                <td class="first">Bathrooms:</td>
                <?php $var52=$GLOBALS['xml']->response->results->result->bathrooms;?>
                <td class="second"><?php if($var52==""):?>N/A</td><?php else:echo number_format(floatval($var52),1,".","")?></td><?php endif;?>
                <td class="third">All Time Property Range:</td>
                <?php $var53=$GLOBALS['xml']->response->results->result->zestimate->valuationRange->low;
                      $var54=$GLOBALS['xml']->response->results->result->zestimate->valuationRange->high;?>
                <td class="fourth"><?php if($var53==""&&$var54==""): ?>N/A</td><?php elseif($var53==""):echo "$".number_format(floatval($var54),2,".",","); ?></td><?php elseif($var54==""):echo "$".number_format(floatval($var53),2,".",","); ?></td><?php else:echo "$".number_format(floatval($var53),2,".",",")."-$".number_format(floatval($var54),2,".",","); ?></td><?php endif;?>
            </tr>
            <tr>
                <td class="first">Bedrooms:</td>
                <?php $var62=$GLOBALS['xml']->response->results->result->bedrooms;?>
                <td class="second"><?php if($var62==""):?>N/A</td><?php else:echo $var62;?></td><?php endif;?>
                <?php $var63=$GLOBALS['xml']->response->results->result->rentzestimate->children()[1];?>
                <td class="third">Rent Zestimate<sup>&#174;</sup> Valuation<?php date_default_timezone_set('PRC');
                                                                    $d=strtotime("$var63");
                                                                    if($var63==""):?>:</td>
                                                                    <?php else:echo " as of ".date("d-M-Y",$d); ?>:</td><?php endif;?>
                <?php $var64=$GLOBALS['xml']->response->results->result->rentzestimate->amount;?>
                <td class="fourth">$<?php if($var64==""):?>N/A</td><?php else:echo number_format(floatval($var64),2,".",",")?></td><?php endif;?>
            </tr>
            <tr>
                <td class="first">Tax Assessment Year:</td>
                <?php $var72=$GLOBALS['xml']->response->results->result->taxAssessmentYear;?>
                <td class="second"><?php if($var72==""):?>N/A</td><?php else:echo $var72?></td><?php endif;?>
                <?php $rchange=$GLOBALS['xml']->response->results->result->rentzestimate->valueChange?>
                <td class="third">30 Days Rent Change<?php if($rchange==""):?>
                                                        <?php elseif($rchange<0): $rchange=-$rchange; ?>
                                                            <img src="http://cs-server.usc.edu:45678/hw/hw6/down_r.gif">
                                                        <?php elseif($rchange>=0): ?>
                                                             <img src="http://cs-server.usc.edu:45678/hw/hw6/up_g.gif">  
                                                        <?php endif; ?>:</td>
                <td class="fourth"><?php if($rchange==""):?>N/A</td>
                                            <?php else:echo "$".number_format(floatval($rchange),2,".",",")?></td><?php endif;?>
            </tr>
            <tr>
                <td class="first">Tax Assessment:</td>
                <?php $var82=$GLOBALS['xml']->response->results->result->taxAssessment;?>
                <td class="second"><?php if($var82==""):?>N/A</td><?php else:echo "$".number_format(floatval($var82),2,".",",")?></td><?php endif;?>
                <td class="third">All Time Rent Range:</td>
                <?php $var83=$GLOBALS['xml']->response->results->result->rentzestimate->valuationRange->low;
                      $var84=$GLOBALS['xml']->response->results->result->rentzestimate->valuationRange->high;?>
                <td class="fourth">$<?php if($var83==""&&$var84==""):?>N/A</td><?php elseif($var83==""): echo "$".number_format(floatval($var84),2,".",",")?></td><?php elseif($var84==""):echo "$".number_format(floatval($var83),2,".",",");?></td><?php else:echo number_format(floatval($var83),2,".",",")."-$".number_format(floatval($var84),2,".",",")?></td><?php endif;?>
            </tr>
        </table>
        <div style="margin:auto;text-align:center">
            <p>&copy;Zillow, Inc., 2006-2014. Use is subject to <a href="http://www.zillow.com/corp/Terms.htm">Terms of Use</a></br>
               <a href="http://www.zillow.com/zestimate/">What's a Zestimate?</a>
            </p>
        </div>

        <?php endif; ?>
        
    </body>
</html>