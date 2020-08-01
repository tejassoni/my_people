<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
	<!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="width=device-width" name="viewport" />
	<!--[if !mso]><!-->
	<meta content="IE=edge" http-equiv="X-UA-Compatible" />
	<!--<![endif]-->
	<title>Person Details</title>
</head>

<body>
	<div class="row">
		<div class="col-sm-4">
			<img class="file_preview_select mb-5" id="missing_person_view" alt="Image Preview" src="{{ $pdf_data['missing_person_img'] }}" height="180" width="auto">
		</div>
		<div class="col-sm-8">
			<table class='table' id='missing_person_tbl'>
				<thead>
					<tr>
						<th scope='col' colspan="4">{{ __('Personal Information') }}</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th scope='col' class="person_name_label">{{ __('Name :') }}</th>
						<td scope='col' class="person_name">{{ $pdf_data['missing_full_name'] }}</td>
						<th scope='col' class="person_gender_label">{{ __('Gender :') }}</th>
						<td scope='col' class="person_gender">{{ $pdf_data['missing_gender'] }}</td>
					</tr>
					<tr>
						<th scope='col' class="person_birthdate_label">{{ __('BirthDate:') }}</th>
						<td scope='col' class="person_birthdate">{{ $pdf_data['birth_date'] }}</td>
						<th scope='col' class="person_age_label">{{ __('Age :') }}</th>
						<td scope='col' class="person_age">{{ $pdf_data['age'] }}</td>
					</tr>
					<tr>
						<th scope='col' class="person_height_label">{{ __('Height:') }}</th>
						<td scope='col' class="person_height">{{ $pdf_data['missing_height'] }}</td>
						<th scope='col' class="person_weight_label">{{ __('Weight :') }}</th>
						<td scope='col' class="person_weight">{{ $pdf_data['missing_weight'] }}</td>
					</tr>
					<tr>
						<th scope='col' class="person_address_label">{{ __('Address :') }}</th>
						<td scope='col' class="person_address" colspan="3">{{ $pdf_data['missing_address'] }}</td>
					</tr>
					<tr>
						<th scope='col' class="person_pincode_label">{{ __('Pincode :') }}</th>
						<td scope='col' class="person_pincode">{{ $pdf_data['pincode'] }}</td>
						<th scope='col' class="person_country_label">{{ __('Country :') }}</th>
						<td scope='col' class="person_country">{{ $pdf_data['country_name'] }}</td>
					</tr>
					<tr>
						<th scope='col' class="person_state_label">{{ __('State :') }}</th>
						<td scope='col' class="person_state">{{ $pdf_data['state_name'] }}</td>
						<th scope='col' class="person_city_label">{{ __('City :') }}</th>
						<td scope='col' class="person_city">{{ $pdf_data['city_name'] }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row d-block text-center">
		<div class="border-bottom">
			<h4>{{ __('Person Identity Hint / Guide Images For Easy to Find') }}</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2 person_additional_details">
			<span class="d-block text-center">{{ __('Face / Jaw Shape') }}</span>
			<img class="file_preview_select mb-5 img-fluid" id="missing_person_face_view" alt="Image Preview" src="{{ $pdf_data['jaw_img'] }}" height="150" width="auto">
		</div>
		<div class="col-sm-2 person_additional_details">
			<span class="d-block text-center">{{ __('Skin Type') }}</span>
			<img class="file_preview_select mb-5 img-fluid" id="missing_person_skin_view" alt="Image Preview" src="{{ $pdf_data['skin_img'] }}" height="150" width="auto">
		</div>
		<div class="col-sm-2 person_additional_details">
			<span class="d-block text-center">{{ __('Hair Style Type') }}</span>
			<img class="file_preview_select mb-5 img-fluid" id="missing_person_hair_view" alt="Image Preview" src="{{ $pdf_data['hair_img'] }}" height="150" width="auto">
		</div>
		<div class="col-sm-2 person_additional_details">
			<span class="d-block text-center">{{ __('Nose Shape') }}</span>
			<img class="file_preview_select mb-5 img-fluid" id="missing_person_nose_view" alt="Image Preview" src="{{ $pdf_data['nose_img'] }}" height="150" width="auto">
		</div>
	</div>

	<div class="row">
		<div class="col-sm-2 person_additional_details">
			<span class="d-block text-center">{{ __('EyeBrow Shape') }}</span>
			<img class="file_preview_select mb-5 img-fluid" id="missing_person_eyebrow_view" alt="Image Preview" src="{{ $pdf_data['eye_brow_img'] }}" height="150" width="auto">
		</div>
		<div class="col-sm-2 person_additional_details">
			<span class="d-block text-center">{{ __('Eye Shape') }}</span>
			<img class="file_preview_select mb-5 img-fluid" id="missing_person_eye_view" alt="Image Preview" src="{{ $pdf_data['eye_img'] }}" height="150" width="auto">
		</div>
		<div class="col-sm-2 person_additional_details">
			<span class="d-block text-center">{{ __('Ear Shape') }}</span>
			<img class="file_preview_select mb-5 img-fluid" id="missing_person_ear_view" alt="Image Preview" src="{{ $pdf_data['ear_img'] }}" height="150" width="auto">
		</div>
		<div class="col-sm-2 person_additional_details">
			<span class="d-block text-center">{{ __('Lip Shape') }}</span>
			<img class="file_preview_select mb-5 img-fluid" id="missing_person_lip_view" alt="Image Preview" src="{{ $pdf_data['lip_img'] }}" height="150" width="auto">
		</div>
	</div>

	<div class="row d-block text-center">
		<div class="border-top">
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<h6><b>{{ __('Cloths Description') }}</b></h6>
			<p class="cloths_description">{{ $pdf_data['cloth_description'] }}</p>
		</div>
		<div class="col-sm-6">
			<h6><b>{{ __('Remarks') }}</b></h6>
			<p class="remarks_description">{{ $pdf_data['remark'] }}</p>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<table class='table' id='missing_person_tbl'>
				<thead>
					<tr>
						<th scope='col' colspan="4">{{ __('Parents / Relatives Information') }}</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th scope='col' class="parent_name_label" width="20%">{{ __('Parents Name :') }}</th>
						<td scope='col' class="parent_name" width="25%">{{ $pdf_data['parent_full_name'] }}</td>
						<th scope='col' class="parent_address_label" width="15%">{{ __('Parents Address :') }}</th>
						<td scope='col' class="parent_address" width="35%">{{ $pdf_data['parent_address'] }}</td>
					</tr>
					<tr>
						<th scope='col' class="parent_email_label" width="20%">{{ __('Parents Email :') }}</th>
						<td scope='col' class="parent_email">{{ $pdf_data['parent_email'] }}</td>
						<th scope='col' class="parent_mobile_label" width="15%">{{ __('Parents Contact :') }}</th>
						<td scope='col' class="parent_mobile" width="35%">{{ $pdf_data['parent_mobile'] }}</td>
					</tr>
					<tr>
						<th scope='col' class="parent_rewards_label">{{ __('Rewards Amount') }}:</th>
						<td scope='col' class="parent_rewards" colspan="3">{{ $pdf_data['amount'].' '.$pdf_data['symbol']  }}
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</body>

</html>

<?php
// echo "<pre> Email Data :: ";
// print_r($pdf_data);
// echo "</pre>";
// exit;
?>