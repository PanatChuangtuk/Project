@extends('administrator.layouts.main')

@section('stylesheet')
    <style>
        body {
            font-family: 'Prompt', 'Sarabun', sans-serif;
            background-color: #f8f9fa;
            color: var(--text-dark);
        }

        .page-title {
            font-weight: 600;
            color: var(--primary-color);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.25rem 1.5rem;
            font-weight: 600;
        }

        .table thead th {
            background-color: var(--secondary-color, #e2e8f0);
            color: #333;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background-color: var(--primary-color, #3b82f6);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1rem;
        }

        .description-cell {
            max-width: 500px;
            line-height: 1.5;
        }

        .date-badge {
            background-color: #f3f4f6;
            color: #111827;
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .empty-state {
            background-color: #fff;
            padding: 3rem;
            text-align: center;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            color: #6b7280;
        }

        .empty-state i {
            font-size: 3rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
        }

        .avatar-img {
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #dee2e6;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .welcome-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #c5f56d, #59ff53, #07974f);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            color: white;
            padding: 2rem;
            text-align: center;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .welcome-logo {
            max-width: 200px;
            margin-bottom: 2rem;
            filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.5));
        }

        .welcome-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            line-height: 1.4;
        }

        .welcome-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            max-width: 800px;
        }

        .welcome-card {
            background-color: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2.5rem;
            max-width: 900px;
            width: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .welcome-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 2rem;
        }

        .welcome-button {
            padding: 0.75rem 1.5rem;
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .welcome-button:hover {
            background-color: white;
            color: #1a2a6c;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .welcome-footer {
            margin-top: 3rem;
            font-size: 0.9rem;
            opacity: 0.7;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .welcome-title {
                font-size: 1.75rem;
            }

            .welcome-card {
                padding: 1.5rem;
            }
        }
    </style>
@endsection

@section('content')
    {{-- <div class="container py-4">
        <h2 class="mb-4 page-title">รายการคำแนะนำอุปกรณ์</h2>

        @if (session('success'))
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>ข้อมูลคำแนะนำอุปกรณ์ทั้งหมด</span>
                <span class="badge bg-primary">
                    <i class="bi bi-list-ul me-1"></i>
                    รายการทั้งหมด: {{ $recommendations->count() }}
                </span>
            </div>
            <div class="card-body p-0">
                @if ($recommendations->isEmpty())
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <p class="mt-2">ยังไม่มีคำแนะนำอุปกรณ์ในขณะนี้</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="text-center">
                                <tr>
                                    <th style="width: 25%;">ผู้แนะนำ</th>
                                    <th style="width: 50%;">คำอธิบาย</th>
                                    <th style="width: 25%;">วันที่เสนอแนะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recommendations as $recommend)
                                    <tr>
                                        <td>
                                            <div class="user-info">
                                                <div class="user-avatar">
                                                    <img src="{{ $recommend->member->info->avatar ? asset('upload/images/' . $recommend->member->info->avatar) : asset('img/default-avatar.png') }}"
                                                        alt="Avatar" class="rounded-circle avatar-img" width="48"
                                                        height="48" data-bs-toggle="modal"
                                                        data-bs-target="#avatarModal-{{ $recommend->id }}"
                                                        style="cursor: pointer;">
                                                </div>

                                                <!-- Modal -->
                                                <div class="modal fade" id="avatarModal-{{ $recommend->id }}" tabindex="-1"
                                                    aria-labelledby="avatarModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content bg-white">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="avatarModalLabel">ภาพโปรไฟล์ของ
                                                                    {{ $recommend->member->info->first_name }}</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="ปิด"></button>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                <img src="{{ $recommend->member->info->avatar ? asset('upload/images/' . $recommend->member->info->avatar) : asset('img/default-avatar.png') }}"
                                                                    alt="Full Avatar" class="img-fluid rounded shadow">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">
                                                        {{ $recommend->member->info->first_name }}
                                                        {{ $recommend->member->info->last_name }}
                                                    </div>

                                                </div>
                                            </div>
                                        </td>
                                        <td class="description-cell">
                                            {{ $recommend->description }}
                                        </td>
                                        <td class="text-center">
                                            <div class="date-badge">
                                                <i class="bi bi-calendar3"></i>
                                                {{ $recommend->created_at->format('d/m/Y H:i') }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $recommendations->links() }}
        </div>
    </div> --}}<div class="welcome-container">
        <div class="welcome-card">
            <img src="{{ asset('upload/logo_fac.png') }}" alt="Faculty Logo" class="welcome-logo">
            <h1 class="welcome-title">มหาวิทยาลัยเทคโนโลยีพระจอมเกล้าพระนครเหนือ <br>คณะครุศาสตร์อุตสาหกรรม</h1>
        </div>
    </div>
@endsection

@section('script')
@endsection
