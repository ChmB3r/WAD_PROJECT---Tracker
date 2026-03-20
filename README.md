# The Tracker (Readers Archive)

## Overview
Readers Archive is a Reading List management system built to track and catalog your Manhwa/Manhua/Manga/Novel reading progress. It allows you to perform full CRUD (Create, Read, Update, Delete) operations on your collection.
> [!NOTE]
> I used api.jikan.moe to get data from MyAnimeList.
## Database Fields
The primary database table (`mangas`) utilizes the following fields:
- **`id`**: Primary Key (Auto-incrementing integer)
- **`mal_id`**: MyAnimeList ID (Integer, nullable)
- **`title`**: Title of the manga (String, required)
- **`type`**: Type of the release (String, nullable)
- **`status`**: Reading status (Enum: 'Plan to read', 'Reading', 'On-hold', 'Completed', 'Dropped' - Default: 'Plan to read')
- **`image_url`**: URL to the manga's cover image (String, nullable)
- **`url`**: URL to the manga's webpage (String, nullable)
- **`created_at`**: Timestamp of record creation
- **`updated_at`**: Timestamp of the last record update

## Screenshots
### Dashboard
<img width="1894" height="914" alt="image" src="https://github.com/user-attachments/assets/2200f094-c2ab-491f-861b-cabbb23931d2" />

### Working CRUD Operations
- Add
  #### Search any Manhwa/Manhua/Manga/Novel that exist in MyAnimeList. Upon search, it should pop-up the searched title.   
  <img width="1905" height="905" alt="{0ED26534-4740-42DB-B95B-231EEBF7226C}" src="https://github.com/user-attachments/assets/56580867-865a-45bb-bdca-d68242d76486" />

  #### After clicking the searched Manhwa/Manhua/Manga/Novel, you can now add it to the List.
  <img width="1883" height="908" alt="{7F1244C8-0C82-47D1-9704-FFFE93E9E592}" src="https://github.com/user-attachments/assets/c5df3dd6-6424-4c00-871f-9901eeb86c0a" />

- Edit
  ### Edit the existing Manhwa/Manhua/Manga/Novel in the List.
  <img width="1906" height="917" alt="{4346CF4D-0F65-4DAE-A24F-B5C4CD02948D}" src="https://github.com/user-attachments/assets/6925b27e-8a5b-41fd-a9e0-cfa92a7093dd" />

- Delete
  ### Remove the existing Manhwa/Manhua/Manga/Novel in the List.
  <img width="1889" height="950" alt="image" src="https://github.com/user-attachments/assets/7a00c44c-3121-4ee3-82fb-45a5b40c62c4" />

  

   
