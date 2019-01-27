<nav class="navbar navbar-default" style="margin-bottom:0px; background-color: white; border: white; ">
                  <div class="container-fluid">
                    <div class="navbar-header">
                      
                      <a class="navbar-brand" href="index.php" style="color:green; font-size:25px; padding-top:10px;"><span><img src="green-pin.png" alt="green" width="28" height="35"/></span> 爱绿评</a>
                    </div>

                    <div class="navbar-collapse collapse in" id="bs-example-navbar-collapse-1" aria-expanded="true" >
                     
                      <form action="search-all.php" class="navbar-form navbar-right" role="search"  >
                                                              <div class="form-group">
                                                                  <label class="sr-only" for="s_company">company:</label>
                                                                  <input type="text" class="form-control input-sm" id="suggestId" name="s_company" placeholder="公司名称 或 （地点+公司名称) / 产业 / 产品 " size="62">
                                                              </div>
                                                              <div class="form-group" >
                                                                  <label class="sr-only" for="s_location">location</label>
                                                                  <input type="text" class="form-control input-sm" name="s_location" placeholder="地点">
                                                              </div>
                        <button type="submit" class="btn btn-default btn-sm">找点评</button>
                      </form>
               
                    </div>

                    <div id="searchResultPanel" style="border:1px solid #C0C0C0;width:150px;height:auto; display:none;"></div>
                    <div id="getCompany"></div>
                    
                  </div>
        </nav>




                  <nav class="navbar navbar-default" style="border-top-left-radius: 0; border-top-right-radius: 0; margin-bottom:0px; border: none;">
                    <div class="container-fluid">
                      <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" >
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span> 
                        </button>
                        <!--<a class="navbar-brand" href="index.php" style="color:lightgreen; font-size:22px; padding-top:2px;"><span><img src="green-pin_2.png" alt="green" width="25" height="30"/></span> LoveGreenGuide</a>-->
                        <a class="navbar-brand" href="index.php" ><span class="glyphicon glyphicon-home"></span></a>


                      </div>
                      <div class="collapse navbar-collapse" id="myNavbar" >
                        <ul class="nav navbar-nav">
                          
                          <li id="profile"><a href="profile.php">我的点评</a></li>
                          <li id="review"><a href="WriteReview.php">写环境点评</a></li> 
                          <li id="map"><a href="map.php">地图浏览点评</a></li> 
                          <li id="guideline"><a href="guidelines.php">诚信公约</a></li>
                          <li id="about" class="dropdown">
                              <a class="dropdown-toggle" data-toggle="dropdown" href="#">关于我们
                              <span class="caret"></span></a>
                              <ul class="dropdown-menu">                                 
                                  <li id="about_2"><a href="http://www.lovegreenguide.com/ch/about.php">关于我们</a></li>
                                  <li id="join"><a href="http://www.lovegreenguide.com/ch/join.php">加入我们</a></li>
                                  <li id="contact"><a href="http://www.lovegreenguide.com/ch/contact.php">联系我们</a></li>
                              </ul>
                          </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                          <li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> 注册</a></li>
                          <li><a href="user.php"><span class="glyphicon glyphicon-log-in"></span> 登录\登出</a></li>
                          <li><a href="../index.php">English</a></li>
                        </ul>
                      </div>
                    </div>
                  </nav>


                 