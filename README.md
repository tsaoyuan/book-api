# API 專案
專案以 call api in postman 方式執行，Models 分別: Book, Image, User
實做: 
- Login 需求的 token 使用 JWT 產生
- Logout 則是 刪除 JWT token
- 使用者的角色分級: `ROLE_ADMIN = 1`, `ROLE_NORMAL = 2`
- 應用 Policy 讓不同權限的使用者，擁有不同功能
- 沒有畫面的情況下，使用 status 來回應前端
  - 例如 delete book 回應  `response()->noContent()`
- 使用 with('user') 預先加載每本書的作者信息，從而減少查詢次數 (N+1) 問題
  - 複習 `Builder` 和 `Collection` 使用方式 
- 多張圖片上傳，在postman 多個 key: 皆用 `image[]`; 單張圖片上傳，在postman  key: `image`
  - 多張圖片的驗證方法:
  ```php
   $request->validate([
        // 驗證 postman 的 key 為 image[] 時， 是不是 array 格式
        'image' => ['array'],
        // 驗證 postman 的 key 在 image[] 時，value (array element)是不是 image 格式 (驗證 array 的 element 是不是 image 格式
        'image.*' => ['image'],
    ]);
  ```
- 圖片上傳至 GCP CS (參考 乙正的方法)
  - `composer require spatie/laravel-google-cloud-storage`
  - 到 GCP 申請 API 憑證
  - `filesystem.php` 和 `.env` 同步設定 (建議變數大寫, 確認有無字錯誤)
- 圖片上傳至 AWS S3 (參考 Mia的方法) 
  - laravel 文件提供: `composer require league/flysystem-aws-s3-v3 "^3.0"`
  - 到 AWS S3 和 IAM 申請 API 憑證
  - `filesystem.php` 和 `.env` 同步設定 (建議變數大寫, 確認有無字錯誤)