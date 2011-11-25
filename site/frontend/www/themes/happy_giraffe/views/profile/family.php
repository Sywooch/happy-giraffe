<?php $this->breadcrumbs = array(
	'Профиль' => array('/profile'),
	'<b>Моя семья</b>',
); ?>

	<div class="profile-form-in">
	
		<div class="subtitle">Семейное положение:</div>
	
		<div class="row">
			<select>
				<option>Замужем</option>
				<option>В активном поиске</option>
			</select>							
		</div>
	
		<div class="row row-inline">
		
			<div class="row-title">Мой муж:</div>
			<div class="row-elements">
				<div class="col">
					<input type="text" />
				</div>									
			</div>
	
		</div>
	
		<div class="photo-upload">
		
			<div class="left">
				<div class="img-box">
					<img src="/images/ava.png" />
					<a href="" class="remove">Удалить</a>
				</div>
				<p>Вы можете загрузить сюда только фотографию Вашего мужа.</p>
			</div>
		
			<div class="upload-btn">
				<div class="file-fake">
					<button class="btn btn-orange"><span><span>Загрузить фото</span></span></button>
					<input type="file" />
				</div>
				<br/>
				Загрузите файл (jpg, gif, png не более 4 МБ)
			</div>
		
		</div>
		<br/>
		<div class="child">
			<div class="age-box">
				<img src="/images/profile_age_img_01.png" /><br/>
				<span>0 - 1</span>
			</div>
			<div class="child-in">
				<a href="javascript:void(0);" class="fill-form" onclick="toggleChildForm(this);">Заполнить данные 1-го ребенка</a>
			</div>
		
			<div class="child-form">
			
				<div class="row row-inline">
				
					<div class="row-title">Имя ребенка:</div>
					<div class="row-elements">
						<div class="col">
							<input type="text" />
						</div>									
					</div>
			
				</div>
				<div class="row row-inline">
		
					<div class="row-title">Дата рождения:</div>
					<div class="row-elements">
						<div class="col">
							<select>
								<option>29</option>
								<option>января</option>
								<option>1981</option>
							</select>
							<select>
								<option>января</option>
								<option>29</option>
								<option>1981</option>
							</select>
							<select>
								<option>1981</option>
								<option>29</option>
								<option>января</option>
							</select>
						</div>
						<div class="col age">
							Возраст: <b>29</b> лет
						</div>
					
					</div>
			
				</div>
			
				<div class="row row-inline">
		
					<div class="row-title">Пол:</div>
					<div class="row-elements">
						<div class="col">
							<label><input type="radio" /> Девочка</label>
						
						</div>
						<div class="col">
							<label><input type="radio" /> Мальчик</label>
						</div>
					
					</div>
			
				</div>
			
				<div class="photo-upload">
				
					<div class="left">
						<div class="img-box noimg">
							<img src="/images/ava_noimg_female.png" />
						
						</div>
						<p>Вы можете загрузить сюда только фотографию Вашего ребенка.</p>
					</div>
				
					<div class="upload-btn">
						<div class="file-fake">
							<button class="btn btn-orange"><span><span>Загрузить фото</span></span></button>
							<input type="file" />
						</div>
						<br/>
						Загрузите файл (jpg, gif, png не более 4 МБ)
					</div>
				
				</div>
			</div>
		
		</div>
		<div class="child">
			<div class="age-box">
				<img src="/images/profile_age_img_02.png" /><br/>
				<span>1 - 3</span>
			</div>
			<div class="child-in">
				<a href="javascript:void(0);" class="fill-form" onclick="toggleChildForm(this);">Заполнить данные 2-го ребенка</a>
			</div>
			<div class="child-form">
			
				<div class="row row-inline">
				
					<div class="row-title">Имя ребенка:</div>
					<div class="row-elements">
						<div class="col">
							<input type="text" />
						</div>									
					</div>
			
				</div>
				<div class="row row-inline">
		
					<div class="row-title">Дата рождения:</div>
					<div class="row-elements">
						<div class="col">
							<select>
								<option>29</option>
								<option>января</option>
								<option>1981</option>
							</select>
							<select>
								<option>января</option>
								<option>29</option>
								<option>1981</option>
							</select>
							<select>
								<option>1981</option>
								<option>29</option>
								<option>января</option>
							</select>
						</div>
						<div class="col age">
							Возраст: <b>29</b> лет
						</div>
					
					</div>
			
				</div>
			
				<div class="row row-inline">
		
					<div class="row-title">Пол:</div>
					<div class="row-elements">
						<div class="col">
							<label><input type="radio" /> Девочка</label>
						
						</div>
						<div class="col">
							<label><input type="radio" /> Мальчик</label>
						</div>
					
					</div>
			
				</div>
			
				<div class="photo-upload">
				
					<div class="left">
						<div class="img-box noimg">
							<img src="/images/ava_noimg_female.png" />
						
						</div>
						<p>Вы можете загрузить сюда только фотографию Вашего ребенка.</p>
					</div>
				
					<div class="upload-btn">
						<div class="file-fake">
							<button class="btn btn-orange"><span><span>Загрузить фото</span></span></button>
							<input type="file" />
						</div>
						<br/>
						Загрузите файл (jpg, gif, png не более 4 МБ)
					</div>
				
				</div>
			</div>
		
		</div>
		<div class="child">
			<div class="age-box">
				<img src="/images/profile_age_img_03.png" /><br/>
				<span>3 - 7</span>
			</div>
			<div class="child-in">
				<a href="javascript:void(0);" class="fill-form" onclick="toggleChildForm(this);">Заполнить данные 3-го ребенка</a>
			</div>
			<div class="child-form">
			
				<div class="row row-inline">
				
					<div class="row-title">Имя ребенка:</div>
					<div class="row-elements">
						<div class="col">
							<input type="text" />
						</div>									
					</div>
			
				</div>
				<div class="row row-inline">
		
					<div class="row-title">Дата рождения:</div>
					<div class="row-elements">
						<div class="col">
							<select>
								<option>29</option>
								<option>января</option>
								<option>1981</option>
							</select>
							<select>
								<option>января</option>
								<option>29</option>
								<option>1981</option>
							</select>
							<select>
								<option>1981</option>
								<option>29</option>
								<option>января</option>
							</select>
						</div>
						<div class="col age">
							Возраст: <b>29</b> лет
						</div>
					
					</div>
			
				</div>
			
				<div class="row row-inline">
		
					<div class="row-title">Пол:</div>
					<div class="row-elements">
						<div class="col">
							<label><input type="radio" /> Девочка</label>
						
						</div>
						<div class="col">
							<label><input type="radio" /> Мальчик</label>
						</div>
					
					</div>
			
				</div>
			
				<div class="photo-upload">
				
					<div class="left">
						<div class="img-box noimg">
							<img src="/images/ava_noimg_female.png" />
						
						</div>
						<p>Вы можете загрузить сюда только фотографию Вашего ребенка.</p>
					</div>
				
					<div class="upload-btn">
						<div class="file-fake">
							<button class="btn btn-orange"><span><span>Загрузить фото</span></span></button>
							<input type="file" />
						</div>
						<br/>
						Загрузите файл (jpg, gif, png не более 4 МБ)
					</div>
				
				</div>
			</div>
		
		</div>
	
		<a href="" class="btn btn-yellow-medium"><span><span>Добавить ребенка</span></span></a>
	
	</div>
</div>
<div class="bottom">
	<button class="btn btn-green-medium btn-arrow-right"><span><span>Сохранить<img src="/images/arrow_r.png" /></span></span></button>
</div>