Chicos FAS LBBC / Butterflies
===========
1. Please look at the "HighLevelArchitecture.png" to understand how we have structured the applications.
2. The Core API is a REST service with common business and data access layers to be used by both versions of the website.
3. Database connections and Naughty words list can be set in Core/api/config/environment.php
	a. If the naughty word list is not set, the application checks for profane words from http://www.wdyl.com/profanity
4. API URL and Facebook credentials can be set in FullWebsite/config/environment.php
5. The mongodump for the master values (US States, Butterflies) is provided.
