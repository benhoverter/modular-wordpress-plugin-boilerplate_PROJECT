<?php

/**
 * This class stores the plugin SQL queries. It is not instanced.
 *
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/config
 */

/**
 * This class stores the plugin SQL queries. It is not instanced.
 * *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/config
 * @author     Ben Hoverter <ben.hoverter@gmail.com>
 */
class Plugin_Abbr_Queries {

	/**
	 * This method retrieves the plugin SQL queries. It is called directly.
	 *
	 * @since    1.0.0
	 */
	public static function get_queries() {
        return self::$queries;
	}


    /**
    * The array used to store all queries the plugin can run.
    * Values are examples only.
    *
    * @since    1.0.0
    * @access   private
    * @var      string    $queries    The array used to store all queries the plugin can run.
    *
    */
    public static $queries = array(

        0 => array(
            'title' => 'Quiz: Average Time, Attempts, Passing percentage',
            'href_value' => 'quiz_avgtime_passpercent',
            'content' => array(
            //  Query Contents: Quiz Name - Post ID - Mean Quiz Time - Attempts - Times Passed - Passing Percentage
                'inner' => array(
                    "table_name" => "quiz_avgtime_passpercent_inner",
                    "query_str" => "CREATE OR REPLACE VIEW quiz_avgtime_passpercent_inner AS
                            SELECT wp_posts.post_title AS Quiz_Name, wp_posts.ID AS Post_ID, DATE_FORMAT( SEC_TO_TIME( AVG( CASE WHEN wp_learndash_user_activity_meta.activity_meta_key='timespent' AND wp_learndash_user_activity_meta.activity_meta_value >=0 THEN wp_learndash_user_activity_meta.activity_meta_value END ) ), '%i:%s' ) AS Mean_Quiz_Time, COUNT(CASE WHEN wp_learndash_user_activity_meta.activity_meta_key='pass' THEN 1 END) AS Attempts, COUNT(CASE WHEN (wp_learndash_user_activity_meta.activity_meta_key='pass' AND wp_learndash_user_activity_meta.activity_meta_value=1) THEN 1 END) AS Times_Passed
                            FROM wp_posts JOIN wp_learndash_user_activity ON wp_posts.ID = wp_learndash_user_activity.post_id
                            JOIN wp_learndash_user_activity_meta ON wp_learndash_user_activity.activity_id = wp_learndash_user_activity_meta.activity_id
                            WHERE wp_posts.post_type = 'sfwd-quiz'
                            GROUP BY Post_ID"
                ),
                'outer' => array(
                            "table_name" => "quiz_avgtime_passpercent",
                            "query_str" => "CREATE OR REPLACE VIEW quiz_avgtime_passpercent AS
                                SELECT *, Times_Passed / Attempts AS Passing_Percentage FROM quiz_avgtime_passpercent_inner
                                WHERE Attempts != Times_Passed ORDER BY Post_ID"
                )
            )
        ),

        1 => array(
            'title' => 'Quiz ID, Question ID, Mean Question Time',
            'href_value' => 'quizid_questionid_meanquestiontime',
            'content' => array(
            // Query Contents: Default Query - Quiz ID - Question ID - Mean Question Time
                'inner' => 0,
                'outer' => array(
                            "table_name" => "quizid_questionid_meanquestiontime",
                            "query_str" => 'CREATE OR REPLACE VIEW quizid_questionid_meanquestiontime AS SELECT wp_wp_pro_quiz_question.quiz_id, wp_wp_pro_quiz_statistic.question_id, FORMAT(AVG( wp_wp_pro_quiz_statistic.question_time ), 0) AS "Mean Question Time"
                            FROM wp_wp_pro_quiz_statistic JOIN wp_wp_pro_quiz_question ON wp_wp_pro_quiz_statistic.question_id = wp_wp_pro_quiz_question.id  GROUP BY quiz_id, question_id'
                )
            )
        )

        // Start next query here.
    );

}

?>
