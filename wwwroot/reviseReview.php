
<div class="container">
	<div class="thumbnail">
		<h3 id="title">Water Issue</h3>
		<div class="row">
			<div class="col-lg-5 col-md-10" id="form">
				<div class="thumbnail">

					<div class="form-group form-inline" id="Type">
						<label for="WaterType">Water Type</label>
						<select class="form-control"  name="WaterType" id="WaterType">
							<option>(Select)</option>
							<option>Lake</option>
							<option>Ocean</option>
							<option>River</option>
							<option>Other</option>
						</select>
					</div>

					<div class="form-group form-inline" id="Type">
						<label for="WaterColor">Water Color</label>
						<select class="form-control" name="WaterColor" id="WaterColor">
							<option>(Select)</option>
							<option>Green</option>
							<option>Blue</option>
							<option>Brown</option>
							<option>Black</option>
							<option>Yellow</option>
							<option>Red</option>
							<option>Other</option>
						</select>
					</div>

					<div class="Turb" id="Type">
						<label for="Turbidity">Turbidity(0 = clear, 10 = Turbidity)</label>
						<div class="btn-group" role="group" aria-label="..." name="turb" id="turb" value="4">
							<input id="turbRate" type="hidden" name="turbRate">
							<input type="button" id="turbNum" class="btn btn-default" style="background-color: rgb(255,255,255)" value="0">
							<input type="button" id="turbNum" class="btn btn-default" style="background-color: rgb(205, 247, 206)" value="1">
							<input type="button" id="turbNum" class="btn btn-default" style="background-color: rgb(162, 249, 164)" value="2">
							<input type="button" id="turbNum" class="btn btn-default" style="background-color: rgb(141, 252, 143)" value="3">
							<input type="button" id="turbNum" class="btn btn-default" style="background-color: rgb(117, 249, 119)" value="4">
							<input type="button" id="turbNum" class="btn btn-default" style="background-color: rgb(92, 249, 94)" value="5">
							<input type="button" id="turbNum" class="btn btn-default" style="background-color: rgb(70, 252, 73)" value="6">
							<input type="button" id="turbNum" class="btn btn-default" style="background-color: rgb(4, 237, 8)" value="7">
							<input type="button" id="turbNum" class="btn btn-default" style="background-color: rgb(3, 198, 6)" value="8">
							<input type="button" id="turbNum" class="btn btn-default" style="background-color: rgb(1, 140, 3)" value="9">
							<input type="button" id="turbNum" class="btn btn-default" style="background-color: rgb(1, 112, 3)" value="10">
						</div>
					</div>
					<div class="Odor" id="Type">
						<label for="Odor">Odor</label>
						<span class="radios">
							<label class="radio-inline">
								<input type="radio" name="WaterOdor" id="inlineRadio1" value="No Smell"> No Smell
							</label>
							<label class="radio-inline">
								<input type="radio" name="WaterOdor" id="inlineRadio2" value="Mild Smell"> Mild Smell
							</label>
							<label class="radio-inline">
								<input type="radio" name="WaterOdor" id="inlineRadio2" value="Strong Smell">Strong Smell
							</label>
						</span>

					</div>
					<div class="float" id="Type">
						<label for="float">Any Float?</label>
						<span class="radios">
							<label class="radio-inline">
								<input type="radio" name="float" id="inlineRadio1" value="1"> Yes
							</label>
							<label class="radio-inline">
								<input type="radio" name="float" id="inlineRadio2" value="0"> No
							</label>
						</span>
						<div class="form-group">
							<label for="FloatType">If there is float, please indicate the type</label>
							<select class="form-control" name="FloatType" id="FloatType">
								<option>(Select)</option>
								<option>Domestic Wastes</option>
								<option>Dead Fishes</option>
								<option>Algaes</option>
								<option>Aquatic Plants</option>
								<option>Others</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-5 col-md-10" id="form">
				<div class="thumbnail" >
					<div class="form-group">
						<label for="Measurement" id="rightHead">Measurement of Parameters</label>
						<table class="table" id="params">
							<thead>
								<tr>
									<td>Parameter</td>
									<td>Measurement</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>DO</td>
									<td><input name="DO" type="text"></td>
								</tr>
								<tr>
									<td>pH</td>
									<td><input name="pH" type="text"></td>
								</tr>
								<tr>
									<td>Turbidity</td>
									<td><input name="Turbidity" type="text"></td>
								</tr>
								<tr>
									<td>BOD</td>
									<td><input name="BOD" type="text"></td>
								</tr>
								<tr>
									<td>COD</td>
									<td><input name="COD" type="text"></td>
								</tr>
								<tr>
									<td>TOC</td>
									<td><input name="TOC" type="text"></td>
								</tr>
								<tr>
									<td>TS</td>
									<td><input name="TS" type="text"></td>
								</tr>
								<tr>
									<td>NH4</td>
									<td><input name="NH4" type="text"></td>
								</tr>
								<tr>
									<td>TP</td>
									<td><input name="TP" type="text"></td>
								</tr>
								<tr>
									<td>Hg</td>
									<td><input name="Hg" type="text"></td>
								</tr>
								<tr>
									<td>Pb</td>
									<td><input name="Pb" type="text"></td>
								</tr>
								<tr>
									<td>Cd</td>
									<td><input name="Cd" type="text"></td>
								</tr>
								<tr>
									<td>As</td>
									<td><input name="As" type="text"></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

			</div>
		</div>
	</div>

</div>



<div class="container">
	<div class="thumbnail">
		<h3 id="title">Air Issue</h3>
		<div class="row">
			<div class="col-lg-5 col-md-10" id="form">
				<div class="thumbnail">
					<div class="form-group form-inline" id="Type">
						<label for="Visibility">Visibility</label>
						<select class="form-control" name="Visibility" id="Visibility">
							<option>(Select)</option>
							<option>< 0.5 km</option>
							<option>0.5 - 2 km</option>
							<option>2 - 10 km</option>
							<option>> 10 km</option>
						</select>
					</div>

					<div class="Odor" id="Type">
						<label for="Odor">Odor</label>
						<span class="radios">
							<label class="radio-inline">
								<input type="radio" name="AirOdor" id="inlineRadio1" value="No Smell"> No Smell
							</label>
							<label class="radio-inline">
								<input type="radio" name="AirOdor" id="inlineRadio2" value="Mild Smell"> Mild Smell
							</label>
							<label class="radio-inline">
								<input type="radio" name="AirOdor" id="inlineRadio2" value="Strong Smell">Strong Smell
							</label>
						</span>

					</div>

					<div class="Smoke" id="Type">
						<label for="SmokeCheck">Any Smoke?</label>
						<span class="radios">
							<label class="radio-inline">
								<input type="radio" name="SmokeCheck" id="inlineRadio1" value="Yes"> Yes
							</label>
							<label class="radio-inline">
								<input type="radio" name="SmokeCheck" id="inlineRadio2" value="No"> No
							</label>
						</span>
						<div class="form-group">
							<label for="SmokeColor">If there is smoke, please indicate the color.</label>
							<select class="form-control" name="SmokeColor" id="SmokeColor">
								<option>(Select)</option>
								<option>Yellow</option>
								<option>Red-Brown</option>
								<option>Black</option>
								<option>White</option>
								<option>Other</option>
							</select>
						</div>
					</div>


					<div class="form-group" id="Type">
						<label for="Symptom">If you feel uncomfortable, please describe.</label>
						<select class="form-control" name="Symptom" id="Symptom">
							<option>(Select)</option>
							<option>Cough</option>
							<option>Difficult Breathing</option>
							<option>Eyes Pain</option>
							<option>Other(please describe it)</option>
						</select>
						<label for="explain">Description</label>
						<input type="text" class="form-control" name="symptomDescr" id="explain" placeholder="Describe your symptom">
					</div>
				</div>
			</div>

			<div class="col-lg-5 col-md-10" id="form">
				<div class="thumbnail" >
					<div class="form-group">
						<label for="Measurement" id="rightHead">Measurement of Parameters</label>
						<table class="table" id="params">
							<thead>
								<tr>
									<td>Parameter</td>
									<td>Measurements</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>PM 2.5</td>
									<td><input name="PM2.5" type="text"></td>
								</tr>
								<tr>
									<td>PM 10</td>
									<td><input name="PM10" type="text"></td>
								</tr>
								<tr>
									<td>O3</td>
									<td><input name="O3" type="text"></td>
								</tr>
								<tr>
									<td>SOx</td>
									<td><input name="SOx" type="text"></td>
								</tr>
								<tr>
									<td>NOx</td>
									<td><input name="NOx" type="text"></td>
								</tr>
								<tr>
									<td>CO</td>
									<td><input name="CO" type="text"></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="thumbnail">
		<h3 id="title">Solid Waste Issue</h3>
		<div class="row">
			<div class="col-lg-5 col-md-10" id="form">
				<div class="thumbnail">
					<div class="form-group form-inline" id="Type">
						<label for="WasteType">Waste Type</label>
						<select class="form-control" name="WasteType" id="WasteType">
							<option>(Select)</option>
							<option>Industrial Wastes</option>
							<option>Agricultural Wastes</option>
							<option>Domestic Wastes</option>
							<option>Others</option>
						</select>
					</div>

					<div class="form-group" id="Type">
						<label for="WasteAmount">Amount(0 = Small Amount, 10 = Large Amount)</label>
						<select class="form-control" name="WasteAmount" id="WasteAmount">
							<option>(Select)</option>
							<option>0</option>
							<option>1</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
							<option>6</option>
							<option>7</option>
							<option>8</option>
							<option>9</option>
							<option>10</option>
						</select>
					</div>

					<div class="Odor" id="Type">
						<label for="Odor">Odor</label>
						<span class="radios">
							<label class="radio-inline">
								<input type="radio" name="WasteOdor" id="inlineRadio1" value="No Smell"> No Smell
							</label>
							<label class="radio-inline">
								<input type="radio" name="WasteOdor" id="inlineRadio2" value="Mild Smell"> Mild Smell
							</label>
							<label class="radio-inline">
								<input type="radio" name="WasteOdor" id="inlineRadio2" value="Strong Smell"> Strong Smell
							</label>
						</span>
					</div>
				</div>
			</div>


			<div class="col-lg-5 col-md-10" id="form">
				<div class="thumbnail" >
					<div class="form-group">
						<label for="comment" id="rightHead">Measurements:</label>
						<textarea class="form-control" name="WasteMeasure" id="comment"></textarea>
					</div>
				</div>
			</div>
		</div>

	</div>
	<!-- <button class="btn btn-default btn-lg" style="margin-left:45%; margin-bottom:50px;">Submit</button>	 -->

	
	<!-- <script type="text/javascript">

	// function clickButton() {

	// }
	// var buttons = document.querySelectorAll("#WasteAmount");
	// var Amount = document.querySelector("#Amount");
	// for (var i = 0; i < buttons.length; i++) {
	// 	//buttons[i].classList.remove("selected");
	// 	buttons[i].addEventListener("click", function() {
	// 		alert(this.value);
	// 		//this.classList.add("selected");
	// 		Amount.value = "" + this.value;
	// 		console.log(Amount.value);
	// 	})
	// }



</script>
-->
