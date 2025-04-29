@extends('main')

@section('title')
    Equipment Management
@endsection

@section('stylesheet')
    <style>
        .equipment-section {
            padding: 30px 15px;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2e4e3f;
            margin-bottom: 25px;
            border-left: 5px solid #89a082;
            padding-left: 15px;
        }

        .equipment-section {
            padding: 30px 0;
            margin-bottom: 70px;
        }

        .equipment-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .equipment-item {
            text-decoration: none;
            color: inherit;
        }

        .equipment-card {
            background: linear-gradient(145deg, #ffffff, #f0f0f0);
            border-radius: 16px;
            padding: 25px 20px;
            text-align: center;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100%;
        }

        .equipment-card:hover {
            background-color: #89a082;
            color: rgb(133, 216, 158);
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .equipment-icon {
            font-size: 2.8rem;
            margin-bottom: 12px;
            color: #89a082;
            transition: color 0.3s ease;
        }

        .equipment-card:hover .equipment-icon {
            color: rgb(133, 216, 158);
        }

        .equipment-name {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .equipment-count {
            margin-top: 6px;
            font-size: 0.95rem;
            color: #6c757d;
        }

        .equipment-card:hover .equipment-count {
            color: rgba(255, 255, 255, 0.85);
        }

        @media (max-width: 768px) {
            .equipment-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 18px;
            }

            .equipment-icon {
                font-size: 2rem;
            }

            .equipment-card {
                padding: 20px 15px;
            }
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="equipment-section">
                    <h2 class="section-title">หมวดหมู่อุปกรณ์</h2>

                    <div class="equipment-grid">
                        @foreach ($equipment as $item)
                            <a href="{{ url('/equipment-list/?type=' . $item->id) }}" class="equipment-item">
                                <div class="equipment-card">

                                    <i class="equipment-icon fas fa-toolbox"></i>
                                    <div class="equipment-name">{{ $item->name }}</div>

                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
