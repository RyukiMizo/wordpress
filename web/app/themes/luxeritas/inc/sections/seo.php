<?php
/**
 * Luxeritas WordPress Theme - free/libre wordpress platform
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @copyright Copyright (C) 2015 Thought is free.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL v2 or later
 * @author LunaNuko
 * @link https://thk.kanzae.net/
 * @translators rakeem( http://rakeem.jp/ )
 */

?>
<ul>
<li>
<p class="control-title"><?php echo __( 'To add tags', 'luxeritas' ); ?></p>
<p class="checkbox">
<input type="checkbox" value="" name="canonical_enable"<?php thk_value_check( 'canonical_enable', 'checkbox' ); ?> />
<?php printf( __( 'Add %s', 'luxeritas' ), 'canonical' . ' ' ); ?>
</p>
</li>
<li>
<p class="checkbox">
<input type="checkbox" value="" name="next_prev_enable"<?php thk_value_check( 'next_prev_enable', 'checkbox' ); ?> />
<?php printf( __( 'Add %s', 'luxeritas' ), 'next / prev' . ' ' ); ?>
</p>
</li>
<li>
<p class="checkbox">
<input type="checkbox" value="" name="rss_feed_enable"<?php thk_value_check( 'rss_feed_enable', 'checkbox' ); ?> />
<?php printf( __( 'Add %s', 'luxeritas' ), 'RSS Feed' . ' ' ); ?>
</p>
</li>
<li>
<p class="checkbox">
<input type="checkbox" value="" name="atom_feed_enable"<?php thk_value_check( 'atom_feed_enable', 'checkbox' ); ?> />
<?php printf( __( 'Add %s', 'luxeritas' ), 'Atom Feed' . ' ' ); ?>
</p>
</li>
<li>
<p class="control-title"><?php echo __( 'The front page meta description', 'luxeritas' ); ?></p>
<input type="text" value="<?php thk_value_check( 'top_description', 'text' ); ?>" name="top_description" />
<p class="f09em"><?php echo __( '* You can change meta description of each post by writing it in &quot;Excerpt&quot; on New Post / Edit Post page.', 'luxeritas' ); ?></p>
<p class="f09em m25-b"><?php echo __( '* You can change meta description of category and tag page by writing it in &quot;Description&quot; on Edit Categories or Tags page.', 'luxeritas' ); ?></p>
</li>
<li>
<p class="control-title"><?php printf( __( 'Setting of %s', 'luxeritas' ), __( 'Structured data ', 'luxeritas' ) ); ?></p>
<p><?php echo __( 'Types of site names recognized by the search engine', 'luxeritas' ); ?></p>
<p class="radio">
<input type="radio" value="WebSite" name="site_name_type"<?php thk_value_check( 'site_name_type', 'radio', 'WebSite' ); ?> />
<?php echo __( 'Web site name', 'luxeritas' ); ?>
</p>
<p class="radio">
<input type="radio" value="Organization" name="site_name_type"<?php thk_value_check( 'site_name_type', 'radio', 'Organization' ); ?> />
<?php echo __( 'Organization name', 'luxeritas' ); ?>:&nbsp;

<select name="organization_type">
<option value="Organization"<?php thk_value_check( 'organization_type', 'select', 'Organization' ); ?>><?php echo __( 'Organization', 'luxeritas' ); ?></option>
<?php
	// Organization sub type
	$orgs = array(
		'Airline'			=> __( 'Airline', 'luxeritas' ),
		'Corporation'			=> __( 'Corporation', 'luxeritas' ),
		'EducationalOrganization'	=> __( 'EducationalOrganization', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp;- <?php echo $val; ?></option>
<?php
	}
	// EducationalOrganization sub type
	$orgs = array(
		'CollegeOrUniversity'	=> __( 'CollegeOrUniversity', 'luxeritas' ),
		'ElementarySchool'	=> __( 'ElementarySchool', 'luxeritas' ),
		'HighSchool'		=> __( 'HighSchool', 'luxeritas' ),
		'MiddleSchool'		=> __( 'MiddleSchool', 'luxeritas' ),
		'Preschool'		=> __( 'Preschool', 'luxeritas' ),
		'School'		=> __( 'School', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// Organization sub type
	$orgs = array(
		'GovernmentOrganization'	=> __( 'GovernmentOrganization', 'luxeritas' ),
		'LocalBusiness'			=> __( 'LocalBusiness', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp;- <?php echo $val; ?></option>
<?php
	}
	// LocalBusiness sub type
	$orgs = array(
		'AnimalShelter'		=> __( 'AnimalShelter', 'luxeritas' ),
		'AutomotiveBusiness'	=> __( 'AutomotiveBusiness', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// AutomotiveBusiness sub type
	$orgs = array(
		'AutoBodyShop'		=> __( 'AutoBodyShop', 'luxeritas' ),
		'AutoDealer'		=> __( 'AutoDealer', 'luxeritas' ),
		'AutoPartsStore'	=> __( 'AutoPartsStore', 'luxeritas' ),
		'AutoRental'		=> __( 'AutoRental', 'luxeritas' ),
		'AutoRepair'		=> __( 'AutoRepair', 'luxeritas' ),
		'AutoWash'		=> __( 'AutoWash', 'luxeritas' ),
		'GasStation'		=> __( 'GasStation', 'luxeritas' ),
		'MotorcycleDealer'	=> __( 'MotorcycleDealer', 'luxeritas' ),
		'MotorcycleRepair'	=> __( 'MotorcycleRepair', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp; &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// LocalBusiness sub type
	$orgs = array(
		'ChildCare'		=> __( 'ChildCare', 'luxeritas' ),
		'DryCleaningOrLaundry'	=> __( 'DryCleaningOrLaundry', 'luxeritas' ),
		'EmergencyService'	=> __( 'EmergencyService', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// EmergencyService sub type
	$orgs = array(
		'FireStation'		=> __( 'FireStation', 'luxeritas' ),
		'PoliceStation'		=> __( 'PoliceStation', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp; &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// LocalBusiness sub type
	$orgs = array(
		'EmploymentAgency'	=> __( 'EmploymentAgency', 'luxeritas' ),
		'EntertainmentBusiness'	=> __( 'EntertainmentBusiness', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// EntertainmentBusiness sub type
	$orgs = array(
		'AdultEntertainment'	=> __( 'AdultEntertainment', 'luxeritas' ),
		'AmusementPark'		=> __( 'AmusementPark', 'luxeritas' ),
		'ArtGallery'		=> __( 'ArtGallery', 'luxeritas' ),
		'Casino'		=> __( 'Casino', 'luxeritas' ),
		'ComedyClub'		=> __( 'ComedyClub', 'luxeritas' ),
		'MovieTheater'		=> __( 'MovieTheater', 'luxeritas' ),
		'NightClub'		=> __( 'NightClub', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp; &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// LocalBusiness sub type
	$orgs = array(
		'FinancialService'	=> __( 'FinancialService', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// FinancialService sub type
	$orgs = array(
		'AccountingService'	=> __( 'AccountingService', 'luxeritas' ),
		'AutomatedTeller'	=> __( 'AutomatedTeller', 'luxeritas' ),
		'BankOrCreditUnion'	=> __( 'BankOrCreditUnion', 'luxeritas' ),
		'InsuranceAgency'	=> __( 'InsuranceAgency', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp; &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// LocalBusiness sub type
	$orgs = array(
		'FoodEstablishment'	=> __( 'FoodEstablishment', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// FoodEstablishment sub type
	$orgs = array(
		'Bakery'		=> __( 'Bakery', 'luxeritas' ),
		'BarOrPub'		=> __( 'BarOrPub', 'luxeritas' ),
		'Brewery'		=> __( 'Brewery', 'luxeritas' ),
		'CafeOrCoffeeShop'	=> __( 'CafeOrCoffeeShop', 'luxeritas' ),
		'FastFoodRestaurant'	=> __( 'FastFoodRestaurant', 'luxeritas' ),
		'IceCreamShop'		=> __( 'IceCreamShop', 'luxeritas' ),
		'Restaurant'		=> __( 'Restaurant', 'luxeritas' ),
		'Winery'		=> __( 'Winery', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp; &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// LocalBusiness sub type
	$orgs = array(
		'GovernmentOffice'	=> __( 'GovernmentOffice', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// GovernmentOffice sub type
	$orgs = array(
		'PostOffice'		=> __( 'PostOffice', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp; &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// LocalBusiness sub type
	$orgs = array(
		'HealthAndBeautyBusiness'	=> __( 'HealthAndBeautyBusiness', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// HealthAndBeautyBusiness sub type
	$orgs = array(
		'BeautySalon'	=> __( 'BeautySalon', 'luxeritas' ),
		'DaySpa'	=> __( 'DaySpa', 'luxeritas' ),
		'HairSalon'	=> __( 'HairSalon', 'luxeritas' ),
		'HealthClub'	=> __( 'HealthClub', 'luxeritas' ),
		'NailSalon'	=> __( 'NailSalon', 'luxeritas' ),
		'TattooParlor'	=> __( 'TattooParlor', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp; &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// LocalBusiness sub type
	$orgs = array(
		'HomeAndConstructionBusiness'	=> __( 'HomeAndConstructionBusiness', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// HomeAndConstructionBusiness sub type
	$orgs = array(
		'Electrician'		=> __( 'Electrician', 'luxeritas' ),
		'GeneralContractor'	=> __( 'GeneralContractor', 'luxeritas' ),
		'HVACBusiness'		=> __( 'HVACBusiness', 'luxeritas' ),
		'HousePainter'		=> __( 'HousePainter', 'luxeritas' ),
		'Locksmith'		=> __( 'Locksmith', 'luxeritas' ),
		'MovingCompany'		=> __( 'MovingCompany', 'luxeritas' ),
		'Plumber'		=> __( 'Plumber', 'luxeritas' ),
		'RoofingContractor'	=> __( 'RoofingContractor', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp; &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// LocalBusiness sub type
	$orgs = array(
		'InternetCafe'	=> __( 'InternetCafe', 'luxeritas' ),
		'LegalService'	=> __( 'LegalService', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// LegalService sub type
	$orgs = array(
		'Attorney'	=> __( 'Attorney', 'luxeritas' ),
		'Notary'	=> __( 'Notary', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp; &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// LocalBusiness sub type
	$orgs = array(
		'Library'		=> __( 'Library', 'luxeritas' ),
		'LodgingBusiness'	=> __( 'LodgingBusiness', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// LodgingBusiness sub type
	$orgs = array(
		'BedAndBreakfast'	=> __( 'BedAndBreakfast', 'luxeritas' ),
		'Campground'		=> __( 'Campground', 'luxeritas' ),
		'Hostel'		=> __( 'Hostel', 'luxeritas' ),
		'Hotel'			=> __( 'Hotel', 'luxeritas' ),
		'Motel'			=> __( 'Motel', 'luxeritas' ),
		'Resort'		=> __( 'Resort', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp; &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// LocalBusiness sub type
	$orgs = array(
		'ProfessionalService'	=> __( 'ProfessionalService', 'luxeritas' ),
		'RadioStation'		=> __( 'RadioStation', 'luxeritas' ),
		'RealEstateAgent'	=> __( 'RealEstateAgent', 'luxeritas' ),
		'RecyclingCenter'	=> __( 'RecyclingCenter', 'luxeritas' ),
		'SelfStorage'		=> __( 'SelfStorage', 'luxeritas' ),
		'ShoppingCenter'	=> __( 'ShoppingCenter', 'luxeritas' ),
		'SportsActivityLocation'=> __( 'SportsActivityLocation', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// SportsActivityLocation sub type
	$orgs = array(
		'BowlingAlley'		=> __( 'BowlingAlley', 'luxeritas' ),
		'ExerciseGym'		=> __( 'ExerciseGym', 'luxeritas' ),
		'GolfCourse'		=> __( 'GolfCourse', 'luxeritas' ),
		'HealthClub'		=> __( 'HealthClub', 'luxeritas' ),
		'PublicSwimmingPool'	=> __( 'PublicSwimmingPool', 'luxeritas' ),
		'SkiResort'		=> __( 'SkiResort', 'luxeritas' ),
		'SportsClub'		=> __( 'SportsClub', 'luxeritas' ),
		'StadiumOrArena'	=> __( 'StadiumOrArena', 'luxeritas' ),
		'TennisComplex'		=> __( 'TennisComplex', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp; &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// LocalBusiness sub type
	$orgs = array(
		'Store'	=> __( 'Store', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// Store sub type
	$orgs = array(
		'BikeStore'		=> __( 'BikeStore', 'luxeritas' ),
		'BookStore'		=> __( 'BookStore', 'luxeritas' ),
		'ClothingStore'		=> __( 'ClothingStore', 'luxeritas' ),
		'ComputerStore'		=> __( 'ComputerStore', 'luxeritas' ),
		'ConvenienceStore'	=> __( 'ConvenienceStore', 'luxeritas' ),
		'DepartmentStore'	=> __( 'DepartmentStore', 'luxeritas' ),
		'ElectronicsStore'	=> __( 'ElectronicsStore', 'luxeritas' ),
		'Florist'		=> __( 'Florist', 'luxeritas' ),
		'FurnitureStore'	=> __( 'FurnitureStore', 'luxeritas' ),
		'GardenStore'		=> __( 'GardenStore', 'luxeritas' ),
		'GroceryStore'		=> __( 'GroceryStore', 'luxeritas' ),
		'HardwareStore'		=> __( 'HardwareStore', 'luxeritas' ),
		'HobbyShop'		=> __( 'HobbyShop', 'luxeritas' ),
		'HomeGoodsStore'	=> __( 'HomeGoodsStore', 'luxeritas' ),
		'JewelryStore'		=> __( 'JewelryStore', 'luxeritas' ),
		'LiquorStore'		=> __( 'LiquorStore', 'luxeritas' ),
		'MensClothingStore'	=> __( 'MensClothingStore', 'luxeritas' ),
		'MobilePhoneStore'	=> __( 'MobilePhoneStore', 'luxeritas' ),
		'MovieRentalStore'	=> __( 'MovieRentalStore', 'luxeritas' ),
		'MusicStore'		=> __( 'MusicStore', 'luxeritas' ),
		'OfficeEquipmentStore'	=> __( 'OfficeEquipmentStore', 'luxeritas' ),
		'OutletStore'		=> __( 'OutletStore', 'luxeritas' ),
		'PawnShop'		=> __( 'PawnShop', 'luxeritas' ),
		'PetStore'		=> __( 'PetStore', 'luxeritas' ),
		'ShoeStore'		=> __( 'ShoeStore', 'luxeritas' ),
		'SportingGoodsStore'	=> __( 'SportingGoodsStore', 'luxeritas' ),
		'TireShop'		=> __( 'TireShop', 'luxeritas' ),
		'ToyStore'		=> __( 'ToyStore', 'luxeritas' ),
		'WholesaleStore'	=> __( 'WholesaleStore', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp; &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// LocalBusiness sub type
	$orgs = array(
		'TelevisionStation'		=> __( 'TelevisionStation', 'luxeritas' ),
		'TouristInformationCenter'	=> __( 'TouristInformationCenter', 'luxeritas' ),
		'TravelAgency'			=> __( 'TravelAgency', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// Organization sub type
	$orgs = array(
		'MedicalOrganization'	=> __( 'MedicalOrganization', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp;- <?php echo $val; ?></option>
<?php
	}
	// MedicalOrganization sub type
	$orgs = array(
		'Dentist'	=> __( 'Dentist', 'luxeritas' ),
		'Hospital'	=> __( 'Hospital', 'luxeritas' ),
		'Pharmacy'	=> __( 'Pharmacy', 'luxeritas' ),
		'Physician'	=> __( 'Physician', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// Organization sub type
	$orgs = array(
		'NGO'			=> __( 'NGO', 'luxeritas' ),
		'PerformingGroup'	=> __( 'PerformingGroup', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp;- <?php echo $val; ?></option>
<?php
	}
	// PerformingGroup sub type
	$orgs = array(
		'DanceGroup'	=> __( 'DanceGroup', 'luxeritas' ),
		'MusicGroup'	=> __( 'MusicGroup', 'luxeritas' ),
		'TheaterGroup'	=> __( 'TheaterGroup', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
	// Organization sub type
	$orgs = array(
		'SportsOrganization'	=> __( 'SportsOrganization', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp;- <?php echo $val; ?></option>
<?php
	}
	// SportsOrganization sub type
	$orgs = array(
		'SportsTeam'	=> __( 'SportsTeam', 'luxeritas' ),
	);
	foreach( $orgs as $key => $val ) {
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'organization_type', 'select', $key ); ?>> &nbsp; &nbsp;&middot; <?php echo $val; ?></option>
<?php
	}
?>
</select>
</p>
</li>

<li>
<p><?php echo __( 'Site logo', 'luxeritas' ); ?></p>
<p class="f09em"><?php echo __( '* the image must be within 600px width, height 60px.', 'luxeritas' ); ?></p>
<?php
	$logo = TURI . '/images/site-logo.png';
	$logo_val = '';
	$site_logo = get_theme_mod( 'site_logo', null );

	if( isset( $site_logo ) ) {
		$logo = $site_logo;
		$logo_val = $site_logo;
	}
?>
<script>thkImageSelector('site-logo', 'Site Logo');</script>
<div id="site-logo-form">
<input id="site-logo" type="hidden" name="site_logo" value="<?php echo $logo_val; ?>" />
<input id="site-logo-set" type="button" class="button" value="<?php echo __( 'Set image', 'luxeritas' ); ?>" />
<input id="site-logo-del" type="button" class="button" value="<?php echo __( 'Delete image', 'luxeritas' ); ?>" />
<?php
	if( !empty( $logo ) ) {
?>
<div id="site-logo-view" style="max-width: 300px"><img src="<?php echo $logo; ?>" alt="Site Logo" style="max-width: 300px" /></div>
<?php
	}
	else {
?>
<div id="site-logo-view" style="max-width: 300px"></div>
<?php
	}
?>
</div>
</li>

<li>
<p><?php echo __( 'Organization logo', 'luxeritas' ), ' ( ' . __( 'Only when &quoValid only when &quot;Organization name&quot; is selected as the type of site name', 'luxeritas' ), ' ) '; ?></p>
<p><span class="bg-gray"><?php echo __( '* Required depending on the selected organization', 'luxeritas' ); ?></span></p>
<p class="radio">
<input type="radio" value="none" name="organization_logo"<?php thk_value_check( 'organization_logo', 'radio', 'none' ); ?> />
<?php echo __( 'There is no organization logo. Or don&apos;t need such a setting', 'luxeritas' ); ?>
</p>
<p class="radio">
<input type="radio" value="set" name="organization_logo"<?php thk_value_check( 'organization_logo', 'radio', 'set' ); ?> />
<?php echo __( 'Make the search engine recognize the following image as &quot;Organization logo&quot;', 'luxeritas' ); ?>
</p>
<p class="f09em"><?php echo __( '* The image must be at least 112 px wide and at least 112 px high.', 'luxeritas' ); ?></p>
<?php
	$logo = '';
	$logo_val = '';
	$org_logo = get_theme_mod( 'org_logo', null );

	if( isset( $org_logo ) ) {
		$logo = $org_logo;
		$logo_val = $org_logo;
	}
?>
<script>thkImageSelector('org-logo', 'Organization Logo');</script>
<div id="org-logo-form">
<input id="org-logo" type="hidden" name="org_logo" value="<?php echo $logo_val; ?>" />
<input id="org-logo-set" type="button" class="button" value="<?php echo __( 'Set image', 'luxeritas' ); ?>" />
<input id="org-logo-del" type="button" class="button" value="<?php echo __( 'Delete image', 'luxeritas' ); ?>" />
<?php
	if( !empty( $logo ) ) {
?>
<div id="org-logo-view" style="max-width: 300px"><img src="<?php echo $logo; ?>" alt="Organization Logo" style="max-width: 300px" /></div>
<?php
	}
	else {
?>
<div id="org-logo-view" style="max-width: 300px"></div>
<?php
	}
?>
</div>
</li>

<li>
<p class="control-title"><?php printf( __( 'Setting of %s', 'luxeritas' ), 'Meta keywords ' ); ?></p>
<p class="radio">
<input type="radio" value="tags" name="meta_keywords"<?php thk_value_check( 'meta_keywords', 'radio', 'tags' ); ?> />
<?php echo __( 'Put tags and category names into meta keywords', 'luxeritas' ); ?>
</p>
<p class="radio">
<input type="radio" value="none" name="meta_keywords"<?php thk_value_check( 'meta_keywords', 'radio', 'none' ); ?> />
<?php echo __( 'Do not need any meta keywords!', 'luxeritas' ); ?>
</p>
</li>
<li>
<p class="control-title"><?php echo __( 'Date to display in Google search results', 'luxeritas' ); ?></p>
<select name="published">
<option value="published"<?php thk_value_check( 'published', 'select', 'published' ); ?>><?php echo __( 'publish date', 'luxeritas' ); ?></option>
<option value="updated"<?php thk_value_check( 'published', 'select', 'updated' ); ?>><?php echo __( 'updated date', 'luxeritas' ); ?></option>
</select>
<p class="f09em"><?php echo __( '* It is a setting of the date to display in Google search results when there is both a publish date and an update date.', 'luxeritas' ); ?></p>
</li>
<li>
<p class="control-title"><?php echo __( 'category and tag pages', 'luxeritas' ); ?></p>
<p class="f09em"><span class="bg-gray"><?php echo __( '* For SEO reasons, you can only select either category or tag page.', 'luxeritas' ); ?></span></p>
<p class="radio">
<input type="radio" value="category" name="category_or_tag_index"<?php thk_value_check( 'category_or_tag_index', 'radio', 'category' ); ?> />
<?php echo __( 'Index category page.', 'luxeritas' ), ' ( ', __( 'Only the first page', 'luxeritas' ), '  )'; ?>
</p>
<p class="radio">
<input type="radio" value="tag" name="category_or_tag_index"<?php thk_value_check( 'category_or_tag_index', 'radio', 'tag' ); ?> />
<?php echo __( 'Index tag page.', 'luxeritas' ), ' ( ', __( 'Only the first page', 'luxeritas' ), '  )'; ?>
</p>
<p class="radio">
<input type="radio" value="none" name="category_or_tag_index"<?php thk_value_check( 'category_or_tag_index', 'radio', 'none' ); ?> />
<?php echo __( 'Prohibit crawlers to index either', 'luxeritas' ); ?>
</p>
</li>
<li>
<p class="control-title"><?php echo __( 'Splitting Content for blog posts and pages', 'luxeritas' ); ?></p>
<p class="checkbox">
<input type="checkbox" value="" name="nextpage_index"<?php thk_value_check( 'nextpage_index', 'checkbox' ); ?> />
<?php echo __( 'Prohibit crawlers to index second page onward when contents are split using &lt;!--nextpage--&gt; tag.', 'luxeritas' ); ?>
</p>
</li>
</ul>
