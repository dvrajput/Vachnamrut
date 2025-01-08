baseUrl = http://127.0.0.1:8000/api;

*------------------------------------------------------*

**get song list api**

URL : baseUrl/get_songs

Resoponse Like :
{
    "status": "success",
    "data": {
        "id": 1,
        "song_code": "Song Code",
        "title_en": "English Title",
        "lyrics_en": "English Lyrics",
        "title_gu": "Gujarati Title",
        "lyrics_gu": "Gujarati Lyrics"
    }
}

*------------------------------------------------------*

**get category list api**

URL = baseUrl/get_category

Resoponse Like :
{
    "status": "success",
    "data": [
        {
            "id": 3,
            "category_code": "CAT1",
            "category_en": "Swaminarayan",
            "category_gu": "સ્વામિનારાયણ"
        }
    ]
}

*------------------------------------------------------*

**get sub category list api**

URL = baseUrl/get_sub_category

Resoponse Like :
{
    "status": "success",
    "data": [
        {
            "id": 3,
            "sub_category_code": "SCAT1",
            "sub_category_en": "Premanand Swami",
            "sub_category_gu": "પ્રેમાનંદ સ્વામી"
        }
    ]
}