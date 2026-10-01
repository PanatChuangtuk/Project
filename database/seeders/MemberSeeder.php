<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * อาจารย์ที่ปรึกษา นักศึกษา สมาชิก และคู่มือ (ไม่รวมบัญชีทดสอบ)
 * ข้อมูลจากฐานข้อมูลเดิม ณ 2026-10-01
 */
class MemberSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('adviser')->upsert([
            ['id' => 1, 'titles_name' => 'ดร.', 'first_name' => 'ธัญญรัตน์', 'last_name' => 'น้อมพลกรัง', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 2, 'titles_name' => 'ดร.', 'first_name' => 'พุทธิดา', 'last_name' => 'สกุลวิริยกิจกุล', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 3, 'titles_name' => 'ดร.', 'first_name' => 'จิรพันธุ์', 'last_name' => 'ศรีสมพันธุ์', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 4, 'titles_name' => 'ดร.', 'first_name' => 'วิทวัส', 'last_name' => 'ทิพย์สุวรรณ', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 5, 'titles_name' => 'ดร.', 'first_name' => 'สมคิด', 'last_name' => 'แซ่หลี', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 6, 'titles_name' => 'ดร.', 'first_name' => 'สรเดช', 'last_name' => 'ครุฑจ้อน', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 7, 'titles_name' => 'ดร.', 'first_name' => 'จรัญ', 'last_name' => 'แสนราช', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 8, 'titles_name' => 'ดร.', 'first_name' => 'วรรณชัย', 'last_name' => 'วรรณสวัสดิ์', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 9, 'titles_name' => 'ดร.', 'first_name' => 'กฤช', 'last_name' => 'สินธนะกุล', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 10, 'titles_name' => 'ดร.', 'first_name' => 'สุธิดา', 'last_name' => 'ชัยชมชื่น', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 11, 'titles_name' => 'ดร.', 'first_name' => 'วาทินี', 'last_name' => 'นุ้ยเพียร', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 12, 'titles_name' => 'ดร.', 'first_name' => 'เทวา', 'last_name' => 'คำปาเชื้อ', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 13, 'titles_name' => 'ดร.', 'first_name' => 'ดวงกมล', 'last_name' => 'โพธิ์นาค', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 14, 'titles_name' => 'ดร.', 'first_name' => 'ธีราทร', 'last_name' => 'สมิทธิวาณิช', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 15, 'titles_name' => 'อาจารย์', 'first_name' => 'พนเมษ', 'last_name' => 'ญาณฐิติรัตน์', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 16, 'titles_name' => 'ดร.', 'first_name' => 'สวนันท์', 'last_name' => 'แดงประเสริฐ', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 17, 'titles_name' => 'ดร.', 'first_name' => 'ภาวพรรณ', 'last_name' => 'ขำทับ', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 18, 'titles_name' => 'ดร.', 'first_name' => 'ภราดร', 'last_name' => 'เสถียรไชยกิจ', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 19, 'titles_name' => 'ดร.', 'first_name' => 'พรสวรรค์', 'last_name' => 'จันทะคัด', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 20, 'titles_name' => 'ดร.', 'first_name' => 'นุชชฎา', 'last_name' => 'เกาะไพศาลสุขวัฒนา', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 21, 'titles_name' => 'นางสาว', 'first_name' => 'เนตรนภา', 'last_name' => 'สุขมงคล', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 22, 'titles_name' => 'นางสาว', 'first_name' => 'สุภาพร', 'last_name' => 'ชื่นสกุล', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 23, 'titles_name' => 'นาย', 'first_name' => 'สุพพัต', 'last_name' => 'กองแก้ว', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 24, 'titles_name' => 'นางสาว', 'first_name' => 'รุ่งนภา', 'last_name' => 'ชุมดี', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 25, 'titles_name' => 'นางสาว', 'first_name' => 'นัชชา', 'last_name' => 'บุญถนอม', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
            ['id' => 26, 'titles_name' => 'นางสาว', 'first_name' => 'สายพิณ', 'last_name' => 'ไตรเมฆ', 'avatar' => null, 'created_at' => '2026-07-18 13:47:10', 'updated_at' => null, 'status' => 1],
        ], ['id']);

        DB::table('student')->upsert([
            ['id' => 1, 'adviser_id' => 1, 'student_number' => 6402041520111, 'first_name' => 'ปณัติ', 'last_name' => 'ช่วงถึก', 'mobile_phone' => '0987651721', 'email' => 'panat32@hotmail.com', 'status' => 1, 'created_at' => '2026-07-26 04:57:53', 'updated_at' => '2026-07-26 04:57:53'],
            ['id' => 9, 'adviser_id' => 1, 'student_number' => 6402041520112, 'first_name' => 'กิตติพงษ์', 'last_name' => 'สุขใจ', 'mobile_phone' => '0891234567', 'email' => 'kittipong@example.com', 'status' => 1, 'created_at' => '2026-08-02 04:19:59', 'updated_at' => '2026-08-02 04:19:59'],
            ['id' => 10, 'adviser_id' => 1, 'student_number' => 6402041520113, 'first_name' => 'ศิริพร', 'last_name' => 'บุญมี', 'mobile_phone' => '0812345678', 'email' => 'siriporn@example.com', 'status' => 1, 'created_at' => '2026-08-02 04:19:59', 'updated_at' => '2026-08-02 04:19:59'],
        ], ['id']);

        DB::table('member')->upsert([
            ['id' => 35, 'role' => 'user', 'password' => '$2y$12$I0FZUc6iITg2XwwPVZhCKeDnqVYd5.MvOmWwlPE03qRlk0g.B2Slq', 'email' => 's642041520111@email.kmutnb.com', 'status' => 1, 'created_at' => '2026-08-08 12:14:33', 'updated_at' => '2026-08-08 12:22:35'],
            ['id' => 36, 'role' => 'admin', 'password' => '$2y$12$MW4/LH3mQnmLC729J9MnUuQ4jtj5EsRd9jKC9JAS82Sglr0WGggbO', 'email' => 'panat32@hotmail.com', 'status' => 1, 'created_at' => '2026-08-09 12:42:21', 'updated_at' => '2026-08-09 12:42:21'],
            ['id' => 40, 'role' => 'user', 'password' => '$2y$12$fzcbYBRoLxcPRuY8VifQZOLqahCFj/xX/TF7dRS7h.lI8hynx9Pq2', 'email' => 'siriporn@example.com', 'status' => 1, 'created_at' => '2026-09-28 14:54:54', 'updated_at' => '2026-09-28 14:54:54'],
        ], ['id']);

        DB::table('member_infomation')->upsert([
            ['id' => 15, 'member_id' => 35, 'adviser_id' => 1, 'student_id' => 1, 'avatar' => null, 'first_name' => 'ปณัติ', 'last_name' => 'ช่วงถึก', 'mobile_phone' => '0987651721', 'created_at' => '2026-08-08 12:14:33', 'updated_at' => '2026-08-08 12:14:33'],
            ['id' => 16, 'member_id' => 36, 'adviser_id' => 0, 'student_id' => 0, 'avatar' => null, 'first_name' => 'panat', 'last_name' => 'chuangtuk', 'mobile_phone' => '0987651721', 'created_at' => '2026-08-09 12:42:21', 'updated_at' => '2026-08-09 12:42:21'],
            ['id' => 20, 'member_id' => 40, 'adviser_id' => 1, 'student_id' => 10, 'avatar' => null, 'first_name' => 'ศิริพร', 'last_name' => 'บุญมี', 'mobile_phone' => '0812345678', 'created_at' => '2026-09-28 14:54:54', 'updated_at' => '2026-09-28 14:54:54'],
        ], ['id']);

        DB::table('guide')->upsert([
            ['id' => 2, 'link_video' => 'videos/1786535591_6a7c5ea7efe5c.mp4', 'video_name' => 'ทดสอบ', 'status' => 1, 'created_at' => '2026-08-12 11:53:11', 'updated_at' => '2026-08-12 11:53:11'],
            ['id' => 3, 'link_video' => 'videos/1786535611_6a7c5ebbc1d9b.mp4', 'video_name' => 'ทดสอบ', 'status' => 1, 'created_at' => '2026-08-12 11:53:31', 'updated_at' => '2026-08-12 11:53:31'],
            ['id' => 4, 'link_video' => 'videos/1786535744_6a7c5f4014f30.mp4', 'video_name' => 'ทดสอบ', 'status' => 1, 'created_at' => '2026-08-12 11:55:44', 'updated_at' => '2026-08-12 11:55:44'],
            ['id' => 5, 'link_video' => 'videos/1786535786_6a7c5f6aca362.mp4', 'video_name' => 'ทดสอบ', 'status' => 1, 'created_at' => '2026-08-12 11:56:26', 'updated_at' => '2026-08-12 11:56:26'],
            ['id' => 6, 'link_video' => 'videos/1786535829_6a7c5f95abfe0.mp4', 'video_name' => 'ทดสอบ', 'status' => 1, 'created_at' => '2026-08-12 11:57:09', 'updated_at' => '2026-08-12 11:57:09'],
            ['id' => 7, 'link_video' => 'videos/1786535918_6a7c5feed938f.mp4', 'video_name' => 'ทดสอบ', 'status' => 1, 'created_at' => '2026-08-12 11:58:38', 'updated_at' => '2026-08-12 11:58:38'],
            ['id' => 8, 'link_video' => 'file/admin/video/คำร้องการสมัครสมาชิก.mp4', 'video_name' => 'คำร้องการสมัครสมาชิก', 'status' => 1, 'created_at' => '2026-08-12 11:59:13', 'updated_at' => '2026-08-16 08:01:00'],
            ['id' => 9, 'link_video' => 'videos/1786535969_6a7c6021c576f.mp4', 'video_name' => 'รายชื่ออาจารย์ที่ปรึกษา', 'status' => 1, 'created_at' => '2026-08-12 11:59:29', 'updated_at' => '2026-08-12 11:59:29'],
            ['id' => 10, 'link_video' => 'videos/1786536024_6a7c605885ac1.mp4', 'video_name' => 'asd', 'status' => 1, 'created_at' => '2026-08-12 12:00:24', 'updated_at' => '2026-08-12 12:00:24'],
            ['id' => 12, 'link_video' => 'file/admin/video/ทดสอบ.1786867417.mp4', 'video_name' => 'ทดสอบ', 'status' => 1, 'created_at' => '2026-08-12 12:05:57', 'updated_at' => '2026-08-16 08:03:37'],
            ['id' => 17, 'link_video' => '0', 'video_name' => 'รายชื่ออาจารย์ที่ปรึกษา', 'status' => 1, 'created_at' => '2026-08-16 05:00:33', 'updated_at' => '2026-08-16 05:00:33'],
            ['id' => 18, 'link_video' => '0', 'video_name' => 'รายชื่ออาจารย์ที่ปรึกษา', 'status' => 1, 'created_at' => '2026-08-16 05:05:22', 'updated_at' => '2026-08-16 05:05:22'],
            ['id' => 19, 'link_video' => '0', 'video_name' => 'รายชื่ออาจารย์ที่ปรึกษา', 'status' => 1, 'created_at' => '2026-08-16 05:13:15', 'updated_at' => '2026-08-16 05:13:15'],
            ['id' => 20, 'link_video' => '0', 'video_name' => 'รายชื่ออาจารย์ที่ปรึกษา', 'status' => 1, 'created_at' => '2026-08-16 05:22:37', 'updated_at' => '2026-08-16 05:22:37'],
            ['id' => 21, 'link_video' => 'file/admin/video/รายชื่ออาจารย์ที่ปรึกษา_1786858336.mp4', 'video_name' => 'รายชื่ออาจารย์ที่ปรึกษา', 'status' => 1, 'created_at' => '2026-08-16 05:32:16', 'updated_at' => '2026-08-16 05:32:16'],
            ['id' => 22, 'link_video' => 'file/admin/video/รายชื่ออาจารย์ที่ปรึกษา_1786865384.mp4', 'video_name' => 'รายชื่ออาจารย์ที่ปรึกษา', 'status' => 1, 'created_at' => '2026-08-16 07:29:44', 'updated_at' => '2026-08-16 07:29:44'],
        ], ['id']);
    }
}
