<h2>What this does:</h2>
Retrieves an NUS student's class details from IVLE and syncs them to Google Calendar.

<h2>Special Dependencies:</h2>

Enable Calendar Access to your Google API Developer Console. Configure your callback URL when enabling Calendar access in Google API according to where you host your project. It should call back to /project_folder/test.php

<h2>Building:</h2>

This is a web application. Copy them to your localhost/server and EDIT "constants.php" in your project directory of the format:

<code>
    <?php<br />
        $developerKey='google_api_developer_key';<br />
        $clientId='google_api_client_id';<br />
        $clientSecret='google_api_client_secret';<br />
    ?><br />

    <script>
        var APIKey="your_ivle_lapi_key";
    </script>
</code>

Starting dates for the first lesons are defined in addToCalendar.php...(This is where the calendar sync takes place. This should be changed depending upon the current semester.

Cheers,<br />
Rahij!
