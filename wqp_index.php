<?php


		//main function test
		function sorter($atts) {
			//collect current user information to use for custom search of existing published exams
			$user = um_profile_id();
			$sTeacher = get_user_meta($user, 'student_teacher', true);
			$sSchool = get_user_meta($user, 'user_school', true);
			$sGrade = get_user_meta($user, 'grade_level', true);
		
			//for custom query of quiz posts for current user
			$return = '';
			if( $content ) {
	        		$return = $content;
	    		}
	
	    		// Shortcode attribute: title="Lorem Ipsum"
	    		if( isset( $atts['title'] ) ) 
	    		{
        		$return .= '<br><h2>' . $atts['title'] . '</h2>';
    			}

    			// Get our custom posts
    			// 'category' is the category ID or a comma separated list of ID numbers
    			$sliders = get_posts( [ 
        			'post_status' => 'publish', 
        			'post_type' => 'quiz',
        			'numberposts' => 10, 
        			'order'=> 'ASC', 
        			'orderby' => 'title',
        			'category' => $atts['id'],
        			'meta_query' => [
        				'relation' => 'AND', 
        				[
        					'key' => 'quiz_school',
        					'value' => $sSchool,
        					'compare' => 'LIKE'
        				],
        				[
        					'key' => 'quiz_grade',
        					'value' => $sGrade,
        					'compare' => 'LIKE'
        				],
        				[
        					'key' => 'quiz_teacher',
        					'value' => $sTeacher,
        					'compare' => 'LIKE'
        				]
        			]

    			]);


    			// Auxiliary variable, don't print <br> in the first element
    			$first = '';

    			// Iterate through the resulting array
    			// and build the final output
    			// Use $slide->post_author, ->post_excerpt, as usual
    			//   $slide->ID can be used to call auxiliary functions 
    			//   such as get_children or get_permalink
    			foreach( $sliders as $slide ) 
    			{
        			$link = get_permalink( $slide->ID );
        			$return .= 
            			$first
            			. '<a href="' . $link . '">'
            			. $slide->post_title 
            			. '</a>
        			';
        			$first = '<br>';
    			}
			//$school_check = the_field('quiz_school');
			//$quiz_grade = the_field('quiz_grade');
			//$quiz_teacher = the_field('quiz_teacher');
	
			return $return;
		}
		add_shortcode('quiziz_sorter', 'sorter');



?>
