<h1>Member Details</h1>

<?php

// echo '<pre>';
// print_r($data); 
// echo '</pre>';

if (isset($_SESSION['ocms_admin_message'])) {
    echo '<div class="ocms-admin-message">' . $_SESSION['ocms_admin_message'] . '</div>';
    unset($_SESSION['ocms_admin_message']);
}

$member_id = isset( $_GET['member_id'] ) ? sanitize_text_field( $_GET['member_id'] ) : '';
$pending_changes = get_user_meta($member_id, 'pending_changes', true);

?>

<div class="ocms-inner container">

    <form method="POST" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" id="ocms_register" class="ocms-validate">

    <?php if ($pending_changes): ?>
    
    <fieldset>

        <h2>Pending Changes</h2>

        <?php

        foreach ($pending_changes as $change):

            echo $change;
            echo '<br>';

        endforeach;

        ?>

    </fieldset>

    <?php endif; ?>

    <fieldset>

    <h2>General</h2>

        <div class="row">
            <div class="col-lg-2">
                <div class="field-group">
                <label for="name_title">Title</label>
                    <div class="select-wrap">
                        <select name="name_title" id="name_title">
                        <option>Select</option>
                            <?php $titles = array(
                                'Mr.',
                                'Mrs.',
                                'Ms.',
                                'Miss',
                            ); 

                            foreach($titles as $title): ?>

                                <option value="<?php echo $title; ?>" <?php echo $data->name_title == $title ? 'selected' : ''; ?>>
                                    <?php echo $title; ?>
                                </option>

                            <?php  endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="field-group">
                    <label for="first_name" class="light">First Name <span class="req">*</span></label>
                    <input type="text" name="first_name" id="first_name" value="<?php echo $data->first_name; ?>" required>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="field-group">
                    <label for="middle_initial" class="light">Middle Initial</label>
                    <input type="text" name="middle_initial" id="middle_initial" value="<?php echo $data->middle_initial; ?>">
                </div>
            </div>
            
            <div class="col-lg-3">
                <div class="field-group">
                    <label for="last_name" class="light">Last Name <span class="req">*</span></label>
                    <input type="text" name="last_name" id="last_name" value="<?php echo $data->last_name; ?>" required>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="field-group">
                    <label for="suffix" class="light">Suffix</label>
                    <input type="text" name="suffix" id="suffix" value="<?php echo $data->suffix; ?>">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="field-group">
                    <label for="professional_designation" class="light">Professional Designation</label>
                    <div class="select-wrap">
                        <select name="professional_designation" id="professional_designation">
                        <option>Select</option>
                            <?php $designations = array(
                                'MD',
                                'DO'
                            ); 

                            foreach($designations as $designation): ?>

                                <option value="<?php echo $designation; ?>"<?php echo $designation == $data->professional_designation ? ' selected' : ''; ?>>
                                    <?php echo $designation; ?>
                                </option>

                            <?php  endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-2">
                <span class="label light">OCMS Alliance</span>
                
                <div class="field-group radio-group">

                    <div class="select-wrap">
                        <select name="ocms_alliance" id="ocms_alliance">
                        <option>Select</option>
                            <?php $alliances = array(
                                'Yes',
                                'No',
                            ); 

                            foreach($alliances as $alliance): ?>
                                <option value="<?php echo $alliance; ?>"<?php echo $alliance == $data->ocms_alliance ? ' selected' : ''; ?>>
                                    <?php echo $alliance; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-2">
                <span class="label light">Board Certified</span>
                
                <div class="field-group radio-group">

                    <div class="select-wrap">
                        <select name="board_certified" id="board_certified">
                        <option>Select</option>
                            <?php $certifieds = array(
                                'Yes',
                                'No',
                                'Pending',
                                'Both',
                                'Eligible'
                            ); 

                            foreach($certifieds as $certified): ?>

                                <option value="<?php echo $certified; ?>"<?php echo $certified == $data->board_certified ? ' selected' : ''; ?>>
                                    <?php echo $certified; ?>
                                </option>

                            <?php  endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="field-group">
                    <label for="other_names" class="light">Other Names Used</label>
                    <input type="text" name="other_names" id="other_names" value="<?php echo $data->other_names; ?>">
                </div>
            </div>

            <div class="col-lg-4">
                <div class="field-group">
                    <label for="birth_year" class="light">Birth Year</label>
                    <input type="text" name="birth_year" id="birth_year" value="<?php echo $data->birth_year; ?>">
                </div>
            </div>

            <div class="col-lg-4">
                <div class="field-group">
                    <label for="gender" class="light">Gender</label>
                    <div class="select-wrap">
                        <select name="gender" id="gender">
                            <option value="">Select</option>
                            <option value="Male"<?php echo $data->gender == 'Male' ? ' selected' : ''; ?>>Male</option>
                            <option value="Female"<?php echo $data->gender == 'Female' ? ' selected' : ''; ?>>Female</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="field-group">
                    <label for="marital_status" class="light">Marital Status</label>
                    <div class="select-wrap">
                        <select name="marital_status" id="marital_status">
                            <option value="">Select</option>

                            <?php 

                            $marital_statuses = array(
                                'single',
                                'married',
                                'divorced',
                                'widowed'
                            );

                            foreach ($marital_statuses as $status) :?>

                            <option value="<?php echo $status; ?>"<?php echo $status == $data->marital_status ? ' selected' : ''; ?>><?php echo ucwords($status); ?></option>

                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="field-group">
                    <label for="spouse_name" class="light">Spouse Name (if applicable)</label>
                    <input type="text" name="spouse_name" id="spouse_name" value="<?php echo $data->spouse_name; ?>">
                </div>
            </div>

            <div class="col-lg-4">
                <div class="field-group">
                    <label for="other_languages" class="light">Other Languages</label>
                    <input type="text" name="other_languages" id="other_languages" value="<?php echo $data->other_languages; ?>">
                </div>
            </div>

            <div class="col-lg-4 field-group">
                
                <span class="label light">Active Military?</span>

                <div class="radio-group">
                    <input type="radio" name="active_military" id="active_military_yes" value="yes"<?php echo $data->active_military == 'yes' ? ' checked' : ''; ?>>
                    <label for="active_military_yes" class="light">Yes</label>             

                    <input type="radio" name="active_military" id="active_military_no" value="no"<?php echo $data->active_military == 'no' ? ' checked' : ''; ?>>
                    <label for="active_military_no" class="light">No</label>  
                </div>
        
            </div>

            <div class="col-lg-4 field-group">
                <label for="military_branch" class="light">If yes, what branch?</label>
                <input type="text" name="military_branch" id="military_branch" value="<?php echo $data->military_branch; ?>">
            </div>

            <div class="col-lg-4 field-group">
                <label for="dates_in_service" class="light">Dates in Service</label>
                <input type="text" name="dates_in_service" id="dates_in_service" value="<?php echo $data->dates_in_service; ?>">
            </div>

        </div>

    </fieldset>

    <fieldset>

        <h2>Contact Information</h2>

        <div class="row">

            <div class="col-lg-4 field-group">
                <label for="home_address" class="light">Address <span class="req">*</span></label>
                <input type="text" name="home_address" id="home_address" value="<?php echo $data->home_address; ?>" required>
            </div>

            <div class="col-lg-4 field-group">
                <label for="home_address2" class="light">Suite/Apartment #</label>
                <input type="text" name="home_address2" id="home_address2" value="<?php echo $data->home_address2; ?>">
            </div>
        
            <div class="col-lg-4 field-group">
                <label for="home_city" class="light">City <span class="req">*</span></label>
                <input type="text" name="home_city" id="home_city" value="<?php echo $data->home_city; ?>" required>
            </div>

            <div class="col-lg-4 field-group">
                <label for="home_state" class="light">State <span class="req">*</span></label>
                <div class="select-wrap state">
                    <select name="home_state" id="home_state" required>
                        <option value="">Select</option>
                        <?php echo ocms_state_list($data->home_state); ?>
                    </select>
                </div>
            </div>
            
            <div class="col-lg-4 field-group">
                <label for="home_zip" class="light">Zip <span class="req">*</span></label>
                <input type="text" name="home_zip" id="home_zip" value="<?php echo $data->home_zip; ?>" required>
            </div>

            <div class="col-lg-4 field-group">
                <label for="home__phone" class="light">Home Phone</label>
                <input type="text" name="home_phone" id="phone" value="<?php echo $data->home_phone; ?>">
            </div>

            <div class="col-lg-4 field-group">
                <label for="cell_phone" class="light">Mobile Phone</label>
                <input type="text" name="cell_phone" id="cell_phone" value="<?php echo $data->cell_phone; ?>">
            </div>

            <div class="col-lg-4 field-group">
                <label for="email" class="light">Email (Used to Login) <span class="req">*</span></label>
                <input type="text" name="email" id="email" value="<?php echo $data->email; ?>" required>
            </div>

            <div class="col-lg-4 field-group">
                <label for="secondary_email" class="light">Secondary Email</label>
                <input type="text" name="secondary_email" id="secondary_email" value="<?php echo $data->secondary_email; ?>">
            </div>

        </div>

    </fieldset>

    <fieldset>

        <h2>Practice Information</h2>

        <div class="row">

            <div class="col-lg-4 field-group">
                <label for="practice_name" class="light">Practice Name</label>
                <input type="text" name="practice_name" id="practice_name" value="<?php echo $data->practice_name; ?>">
            </div>

            <div class="col-lg-4 field-group">
                <label for="work_phone" class="light">Office Phone Number</label>
                <input type="text" name="work_phone" id="work_phone" value="<?php echo $data->work_phone; ?>">
            </div>

            <div class="col-lg-4 field-group">
                <label for="work_address" class="light">Office Address</label>
                <input type="text" name="work_address" id="work_address" value="<?php echo $data->work_address; ?>">
            </div>

            <div class="col-lg-4 field-group">
                <label for="work_address2" class="light">Office Apartment/Suite #</label>
                <input type="text" name="work_address2" id="work_address2" value="<?php echo $data->work_address2; ?>">
            </div>

            <div class="col-lg-4 field-group">
                <label for="work_city" class="light">Office City</label>
                <input type="text" name="work_city" id="work_city" value="<?php echo $data->work_city; ?>">
            </div>

            <div class="col-lg-4 field-group">
                <label for="work_state" class="light">Office State</label>
                <div class="select-wrap state">
                    <select name="work_state" id="work_state">
                        <option value="">Select</option>
                        <?php echo ocms_state_list($data->work_state); ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-4 field-group">
                <label for="work_zip" class="light">Office Zip</label>
                <input type="text" name="work_zip" id="work_zip" value="<?php echo $data->work_zip; ?>">
            </div>

            <div class="col-lg-4 field-group">
                <label for="work_website" class="light">Office Website</label>
                <input type="url" name="work_website" id="work_website" value="<?php echo $data->work_website; ?>">
            </div>

            <div class="col-lg-4 field-group">
                <label for="office_manager_name" class="light">Office Manager Name</label>
                <input type="text" name="office_manager_name" id="office_manager_name" value="<?php echo $data->office_manager_name; ?>">
            </div>

            <div class="col-lg-4 field-group">
                <label for="office_manager_phone" class="light">Office Manager Phone</label>
                <input type="text" name="office_manager_phone" id="office_manager_phone" value="<?php echo $data->office_manager_phone; ?>">
            </div>

            <div class="col-lg-4 field-group">
                <label for="office_manager_email" class="light">Office Manager Email</label>
                <input type="text" name="office_manager_email" id="office_manager_email" value="<?php echo $data->office_manager_email; ?>">
            </div>

            <div class="col-lg-4 field-group">
                <label for="practice_type" class="light">Practice Type</label>

                <div class="select-wrap">

                    <select name="practice_type" id="practice_type">
                        <option value="">Select</option>

                        <?php 

                        $practice_types = array(
                            'Select',
                            'Solo',
                            'Partnership',
                            'Small Group',
                            'Large Group',
                            'Employed',
                            'Full Time Academic',
                            'Administrative/Consultant'
                        );

                        foreach ($practice_types as $practice_type) :?>

                        <option value="<?php echo $practice_type; ?>"<?php echo $practice_type == $data->practice_type ? ' selected' : ''; ?>><?php echo $practice_type; ?></option>

                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-4 field-group">
                <label for="fax_number" class="light">Fax Number</label>
                <input type="text" name="fax_number" id="fax_number" value="<?php echo $data->fax_number; ?>">
            </div>

            <div class="col-lg-4 field-group">
                <label for="secondary_fax" class="light">Secondary Fax Number</label>
                <input type="text" name="secondary_fax" id="secondary_fax" value="<?php echo $data->secondary_fax; ?>">
            </div>

            <div class="col-lg-8 field-group">
                <span class="label light">Would you like us to contact your office manager with billing and/or membership questions?</span>

                <div class="radio-group">
                    <input type="radio" name="contact_office_manager" id="contact_office_manager_yes" value="yes"<?php echo $data->contact_office_manager == 'yes' ? ' checked' : ''; ?>>
                    <label for="contact_office_manager_yes" class="light">Yes</label>             

                    <input type="radio" name="contact_office_manager" id="contact_office_manager_no" value="no"<?php echo $data->contact_office_manager == 'no' ? ' checked' : ''; ?>>
                    <label for="contact_office_manager_no" class="light">No</label>
                </div>

            </div>

        </div>

    </fieldset>

    <fieldset>

        <h2>Professional Information</h2>

        <div class="row">

            <div class="col-lg-4 field-group">
                <label for="practice_start_date" class="light">Medical Practice Start Date</label>
                <input type="date" name="practice_start_date" id="practice_start_date" value="<?php echo $data->practice_start_date; ?>">
            </div>

            <div class="col-lg-4 field-group">
                <label for="specialty" class="light">Primary Specialty</label>
                <div class="select-wrap">
                    <select name="specialty" id="specialty">
                        
                        <option value="">Select</option>

                        <?php 

                        $specialties = array (
                            'Addiction Medicine',
                            'ADM',
                            'Allergy & Immunology',
                            'Anatomic/Clinical Pathology',
                            'Anesthesiology',
                            'Bariatric Surgery',
                            'Bloodbanking',
                            'Cardiovascular Diseases',
                            'Cardiovascular Diseases TS',
                            'Child Psychiatry',
                            'Child Psychiatry/Adolescent',
                            'Clinical Pathology',
                            'Colon & Rectal Surgery',
                            'Cosmetic Surgery',
                            'Critical Care Medicine',
                            'Dermatology',
                            'Dermatopathology',
                            'Diagnostic Radiology',
                            'Emergency Medicine',
                            'Endocrinology',
                            'Facial Plastic Surgery',
                            'Family Medicine',
                            'Gastroenterology',
                            'General Practice',
                            'General Surgery',
                            'Geriatrics',
                            'Gynecological Oncology',
                            'Gynecology',
                            'Hand Surgery',
                            'Hematology',
                            'Hospitalist',
                            'Infectious Diseases',
                            'Infectious Diseases/Internal Medicine',
                            'Integrative Medicine',
                            'Internal Medicine',
                            'Medical Director',
                            'Neonatal-Perinatal',
                            'Nephrology',
                            'Neurological Surgery',
                            'Neurology',
                            'Neuroradiology',
                            'Nuclear Medicine',
                            'Obesity Med.',
                            'Obstetrics/Gynecology',
                            'Occupational Medicine',
                            'Oncology',
                            'Ophthalmology',
                            'Orthopedic Surgery',
                            'Otolaryngology',
                            'Pain Mgt.',
                            'Pathology',
                            'Pediatric Cardiology',
                            'Pediatric Pulmonology',
                            'Pediatrics',
                            'Phlebology',
                            'Physical Med & Rehab',
                            'Plastic Surgery',
                            'Psychiatry',
                            'Public Health',
                            'Pulmonary Diseases',
                            'Radiation Oncology',
                            'Radiology',
                            'Reproductive Endocrinology',
                            'RETIRED',
                            'Rheumatology',
                            'Sports Med.',
                            'Thoracic Surgery',
                            'Urological Surgery',
                            'Urology',
                            'Vascular Surgery',
                        );

                        foreach ($specialties as $specialty): ?>
                            <option value="<?php echo $specialty; ?>" <?php echo $data->specialty == $specialty ? ' selected' : ''; ?>><?php echo $specialty; ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>
            </div>

            <div class="col-lg-4 field-group">
                <label for="secondary_specialty" class="light">Secondary Specialty</label>
                <div class="select-wrap">
                    <select name="secondary_specialty" id="secondary_specialty">
                        <option value="">Select</option>
                        <?php foreach ($specialties as $specialty): ?>
                            <option value="<?php echo $specialty; ?>"<?php echo $data->secondary_specialty == $specialty ? ' selected' : ''; ?>><?php echo $specialty; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-4 field-group">
                <label for="school" class="light">Medical School Name</label>
                <input type="text" name="school" id="school" value="<?php echo $data->school; ?>">
            </div>

            <div class="col-lg-4 field-group">
                <label for="graduation_year" class="light">Medical School Graduation Year</label>
                <input type="text" name="graduation_year" id="graduation_year" value="<?php echo $data->graduation_year; ?>">
            </div>

            <div class="col-lg-4 field-group">
                <label for="residency_name" class="light">Residency Name/Location</label>
                <input type="text" name="residency_name" id="residency_name" value="<?php echo $data->residency_name; ?>">
            </div>

            <div class="col-lg-4 field-group">
                <label for="year_residency_completed" class="light">Year Residency Completed</label>
                <input type="text" name="year_residency_completed" id="year_residency_completed" value="<?php echo $data->year_residency_completed; ?>">
            </div>

            <div class="col-lg-4 field-group">
                <label for="internship_name" class="light">Internship Name/Location</label>
                <input type="text" name="internship_name" id="internship_name" value="<?php echo $data->internship_name; ?>">
            </div>

            <div class="col-lg-4 field-group">
                <label for="year_internship_completed" class="light">Year Internship Completed</label>
                <input type="text" name="year_internship_completed" id="year_internship_completed" value="<?php echo $data->year_internship_completed; ?>">
            </div>

            <div class="col-lg-4 field-group">
                <label for="license_number" class="light">License Number</label>
                <input type="text" name="license_number" id="license_number" value="<?php echo $data->license_number; ?>">
            </div>

        </div>

    </fieldset>

    <fieldset>

        <h3 class="mb-0">Directory Contact Info</h3>
        <p class="ocms-helper-text">This is optional information you can choose to display on your profile for active members to see.</p>

        <div class="row">

            <div class="col-lg-4">
                <div class="field-group">
                    <label for="facebook" class="light">Facebook Profile Link</label>  
                    <input type="url" name="facebook" id="facebook" value="<?php echo $data->facebook; ?>">
                </div>
            </div>

            <div class="col-lg-4">
                <div class="field-group">
                    <label for="linkedin" class="light">LinkedIn Profile Link</label>  
                    <input type="url" name="linkedin" id="linkedin" value="<?php echo $data->linkedin; ?>">
                </div>
            </div>

            <div class="col-lg-4">
                <div class="field-group">
                    <label for="twitter" class="light">Twitter Profile Link</label>  
                    <input type="url" name="twitter" id="twitter" value="<?php echo $data->twitter; ?>">
                </div>
            </div>

            <div class="col-lg-4">
                <div class="field-group">
                    <label for="instagram" class="light">Instagram Profile Link</label>  
                    <input type="url" name="instagram" id="instagram" value="<?php echo $data->instagram; ?>">
                </div>
            </div>

            <div class="col-lg-4">
                <div class="field-group">
                    <label for="doximity" class="light">Doximity Profile Link</label>  
                    <input type="url" name="doximity" id="doximity" value="<?php echo $data->doximity; ?>">
                </div>
            </div>

            <div class="col-lg-4">
                <div class="field-group">
                    <label for="directory_phone" class="light">Personal Cell Phone Number</label>  
                    <input type="tel" name="directory_phone" id="directory_phone" value="<?php echo $data->directory_phone; ?>">
                </div>
            </div>

            <div class="col-lg-4">
                <div class="field-group">
                    <label for="directory_email" class="light">Personal Email Address</label>  
                    <input type="email" name="directory_email" id="directory_email" value="<?php echo $data->directory_email; ?>">
                </div>
            </div>

            <div class="col-lg-12">
                <div class="field-group">
                    <label for="bio" class="light">Bio</label>  
                    <textarea name="bio" id="bio" style="height: 200px;"><?php echo $data->bio; ?></textarea>
                </div>
            </div>

        </div>
            
    </fieldset>

    <fieldset>

        <h2>Other</h2>

        <div class="row">

            <div class="col-lg-4 field-group">
                <label for="printed_bulletin" class="light">Printed Bulletin?</label>
                <div class="select-wrap">
                    <select name="printed_bulletin" id="printed_bulletin">
                        <option value="">Select</option>

                        <?php 
                        
                        $printed_bulletins = array(
                            'yes',
                            'no'
                        );
                        
                        foreach ($printed_bulletins as $printed_bulletin): ?>
                            <option value="<?php echo $printed_bulletin; ?>" <?php echo $data->printed_bulletin == $printed_bulletin ? 'selected' : ''; ?>><?php echo ucwords($printed_bulletin); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>  
            </div>

            <div class="col-lg-4 field-group">
                <label for="printed_bulletin" class="light">Newsletter?</label>
                <div class="select-wrap">
                    <select name="printed_bulletin" id="printed_bulletin">
                        <option value="">Select</option>

                        <?php 
                        
                        $printed_bulletins = array(
                            'yes',
                            'no'
                        );
                        
                        foreach ($printed_bulletins as $printed_bulletin): ?>
                            <option value="<?php echo $printed_bulletin; ?>" <?php echo $data->printed_bulletin == $printed_bulletin ? 'selected' : ''; ?>><?php echo ucwords($printed_bulletin); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>  
            </div>

            <div class="col-lg-4">
                <div class="field-group">
                    <label for="mailing_preference" class="light">Mailing Preference</label>

                    <div class="select-wrap">
                        <select name="mailing_preference" id="mailing_preference">
                            <option value="">Select</option>

                            <?php 
                            
                            $mailing_preferences = array(
                                'Home',
                                'Work',
                                'Secondary Work'
                            );
                            
                            foreach ($mailing_preferences as $mailing_preference): ?>
                                <option value="<?php echo $mailing_preference; ?>" <?php echo $data->mailing_preference == $mailing_preference ? 'selected' : ''; ?>><?php echo ucwords($mailing_preference); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>                    
                </div>
            </div>

            <div class="col-lg-4">            
                <div class="field-group">
                    
                    <label for="show_in_directory" class="light">Show in Physician Search?</label>

                    <div class="select-wrap">

                        <select name="show_in_directory" id="show_in_directory">
                            
                            <option value="">Select</option>
                            
                            <option value="yes" <?php echo strtolower( $data->show_in_directory ) == 'yes' ? 'selected' : ''; ?>>Yes</option>
                            <option value="personal" <?php echo strtolower( $data->show_in_directory ) == 'personal' ? 'selected' : ''; ?>>Yes & Show Extra Contact Info</option>
                            <option value="no" <?php echo strtolower( $data->show_in_directory ) == 'no' ? 'selected' : ''; ?>>No</option>

                        </select>

                    </div>  
                </div>
            </div>

            <div class="col-lg-4 field-group">
                <label for="communication_preferences" class="light">Communication Preferences</label>

                <div class="select-wrap">
                    <select name="communication_preferences[]" id="communication_preferences" multiple>
                    <?php

                        $prefs = array(
                            'Email',
                            'Text',
                            'Fax',
                            'Office Mail',
                            'Home Mail'
                        );

                        foreach ($prefs as $pref): ?>
                            <option value="<?php echo $pref; ?>" <?php if (strpos($data->communication_preferences, $pref) !== false) { echo 'selected'; } ?>><?php echo $pref; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="ocms-helper-text">Select all that apply.</div>
            </div>

            <div class="col-lg-4 field-group">

                <?php
                $member_id = $_GET['member_id'];
                $has_image = get_user_meta($member_id, 'has_image', true);
                $image_id = '';

                if ($has_image == 'yes') {
                    $image_id = get_user_meta($member_id, 'member_image', true);
                    $image_link = get_edit_post_link($image_id);
                    $image_name = get_the_title($image_id);
                }

                ?>

                <label for="member_image" class="light">Image</label>

                <div class="ocms-member-image-wrap" <?php echo $has_image == 'no' ? 'style="display: none;"' : ''; ?>>
                    <a href="#" class="ocms-remove-member-image">X</a>
                    <a href="<?php echo $image_link; ?>" class="ocms-image-link" target="_blank"><?php echo $image_name; ?></a>
                </div>

                <a href="#" class="button button-inverse ocms-choose-member-image" <?php echo $has_image == 'yes' ? 'style="display: none;"' : ''; ?>>Choose Image</a>
                <input type="hidden" name="has_image" value="<?php echo $has_image; ?>">
                <input type="hidden" name="member_image" value="<?php echo $image_id; ?>">
            </div>

            <div class="col-lg-4 field-group">
                <label for="status" class="light">Status</label>
                <div class="select-wrap">
                    <select name="status" id="status">
                        <option value="">Select</option>

                        <?php 
                        
                        $statuses = array(
                            'approved',
                            'pending',
                            'inactive'
                        );
                        
                        foreach ($statuses as $status): ?>
                            <option value="<?php echo $status; ?>" <?php echo $data->status == $status ? 'selected' : ''; ?>><?php echo ucwords($status); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>  
            </div>

            <div class="col-lg-4 field-group">
                <label for="involvement_category" class="light">Involvement Category</label>
                <div class="select-wrap">
                    <select name="involvement_category[]" id="involvement_category" multiple>
                        <option value="">Select</option>

                        <?php

                        $terms = get_terms( array(
                            'taxonomy' => 'involvement-category',
                            'hide_empty' => false,
                        ) );

                        foreach ($terms as $term): ?>
                            <option value="<?php echo $term->slug; ?>" <?php if (strpos($data->involvement_category, $term->slug) !== false) { echo 'selected'; } ?>><?php echo $term->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>  
            </div>

        </div>

 

    </fieldset>

    <fieldset>

        <h2>Member Status</h2>

        <div class="row">

            <div class="col-lg-3 field-group">
                <label for="membership_status" class="light">Membership Status</label>
                <input type="text" name="membership_status" id="membership_status" value="<?php echo $data->membership_status; ?>">
            </div>

            <div class="col-lg-3 field-group">
                <label for="date_paid" class="light">Date Paid</label>
                <input type="text" name="date_paid" id="date_paid" value="<?php echo $data->date_paid; ?>">
            </div>

            <div class="col-lg-3 field-group">
                <label for="payment_method" class="light">Payment Method</label>
                <input type="text" name="payment_method" id="payment_method" value="<?php echo $data->payment_method; ?>">
            </div>

            <div class="col-lg-3 field-group">
                <span class="label" class="light">Installments?</span>

                <div class="radio-group">
                    <input type="radio" name="installments" id="installments_yes" value="yes"<?php echo $data->installments == 'Yes' ? ' checked' : ''; ?>>
                    <label for="installments_yes" class="light">Yes</label>             

                    <input type="radio" name="installments" id="installments_no" value="no"<?php echo $data->installments == 'No' ? ' checked' : ''; ?>>
                    <label for="installments_no" class="light">No</label>  
                </div>
            </div>

            <div class="col-lg-3 field-group">
                <label for="membership_year" class="light">Membership Year</label>
                <input type="text" name="membership_year" id="membership_year" value="<?php echo $data->membership_year; ?>">
            </div>

            <div class="col-lg-3 field-group">
                <label for="initial_membership_year" class="light">Initial Membership Year</label>
                <input type="text" name="initial_membership_year" id="initial_membership_year" value="<?php echo $data->initial_membership_year; ?>">
            </div>

            <div class="col-lg-3 field-group">
                <label for="final_membership_year" class="light">Final Membership Year</label>
                <input type="text" name="final_membership_year" id="final_membership_year" value="<?php echo $data->final_membership_year; ?>">
            </div>

            <div class="col-lg-3 field-group">
                <label for="date_elected" class="light">Date Elected</label>
                <input type="text" name="date_elected" id="date_elected" value="<?php echo $data->date_elected; ?>">
            </div>

        </div>

        <br>
        <h2>Dues Paid</h2>

        <div class="row">

            <div class="col-lg-3 field-group">
                <label for="dues_ama" class="light">AMA</label>
                <input type="text" name="dues_ama" id="dues_ama" value="<?php echo $data->dues_ama; ?>">
            </div>

            <div class="col-lg-3 field-group">
                <label for="dues_osma" class="light">OSMA</label>
                <input type="text" name="dues_osma" id="dues_osma" value="<?php echo $data->dues_osma; ?>">
            </div>

            <div class="col-lg-3 field-group">
                <label for="dues_ocms" class="light">OCMS</label>
                <input type="text" name="dues_ocms" id="dues_ocms" value="<?php echo $data->dues_ocms; ?>">
            </div>

            <div class="col-lg-3 field-group">
                <label for="dues_bulletin" class="light">Bulletin</label>
                <input type="text" name="dues_bulletin" id="dues_bulletin" value="<?php echo $data->dues_bulletin; ?>">
            </div>

            <div class="col-lg-3 field-group">
                <label for="dues_ocms_scholarship_fund" class="light">OCMS Scholarship Fund</label>
                <input type="text" name="dues_ocms_scholarship_fund" id="dues_ocms_scholarship_fund" value="<?php echo $data->dues_ocms_scholarship_fund; ?>">
            </div>

            <div class="col-lg-3 field-group">
                <label for="dues_ocms_community_foundation" class="light">OCMS Community Foundation</label>
                <input type="text" name="dues_ocms_community_foundation" id="dues_ocms_community_foundation" value="<?php echo $data->dues_ocms_community_foundation; ?>">
            </div>

            <div class="col-lg-3 field-group">
                <label for="dues_osma_foundation" class="light">OSMA Foundation</label>
                <input type="text" name="dues_osma_foundation" id="dues_osma_foundation" value="<?php echo $data->dues_osma_foundation; ?>">
            </div>
            
            <div class="col-lg-3 field-group">
                <label for="dues_ohpp" class="light">OHPP Foundation</label>
                <input type="text" name="dues_ohpp" id="dues_ohpp" value="<?php echo $data->dues_ohpp; ?>">
            </div>

            <div class="col-lg-3 field-group">
                <label for="overpayment_amount" class="light">Overpayment Amount</label>
                <input type="text" name="overpayment_amount" id="overpayment_amount" value="<?php echo $data->overpayment_amount; ?>">
            </div>

            <div class="col-lg-3 field-group">
                <label for="dues_occs" class="light">OCCS</label>
                <input type="text" name="dues_occs" id="dues_occs" value="<?php echo $data->dues_occs; ?>">
            </div>

            <div class="col-lg-3 field-group">
                <label for="dues_occs_date_paid" class="light">OCCS Date Paid</label>
                <input type="text" name="dues_occs_date_paid" id="dues_occs_date_paid" value="<?php echo $data->dues_occs_date_paid; ?>">
            </div>

            <div class="col-lg-3 field-group">
                <label for="total_amount_paid" class="light">Total Amount Paid</label>
                <input type="text" name="total_amount_paid" id="total_amount_paid" value="<?php echo $data->total_amount_paid; ?>">
            </div>

        </div>

        <div class="field-group">
            <label for="status_notes" class="light">Status Notes</label>  
            <textarea name="status_notes" id="status_notes" style="height: 200px;"><?php echo $data->status_notes; ?></textarea>
        </div>

    </fieldset>

    <div class="wp-ui-core">
        <?php wp_nonce_field('ocms_update_member', 'ocms_update_member_nonce'); ?>
        <input type="hidden" name="member_id" value="<?php echo $_GET['member_id']; ?>">
        <input name="action" type="hidden" value="ocms_update_member">
        <input class="button-primary" type="submit" id="submit" value="Save">
    </div>

    </form>

</div>