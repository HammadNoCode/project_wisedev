<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">

    <title>Staff Profile</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        .img-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-top: 20px;
        }

        body {
            font-family: 'Open Sans', sans-serif !important;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        label {
            font-family: 'Open Sans', sans-serif !important;
        }

        h3 {
            font-family: 'Open Sans', sans-serif !important;
        }

        p {
            line-height: 1.3;
        }

        label {
            padding-bottom: 7px;
        }

        .name-title {
            font-size: 2em;
            font-weight: 700;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
        }

        table, th, td {
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <div>
        @foreach($nurse_data as $nurse)
        <div class="row">
            <div class="col-xs-12">
                <div class="name-title text-center" style="text-transform: capitalize;">{{$nurse->first_name}} {{$nurse->last_name}}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <label class="h4"><b>About Me</b></label>
                @if($nurse->about_me)
                <p>{{$nurse->about_me->about_me}}</p>
                @else
                <p>N/A</p>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <label class="h4"><b>DBS Details</b></label>
                @if($nurse->dbs_details)
                <p>
                    DBS Number: {{$nurse->dbs_details->dbs_number}}<br>
                    Issue Date: {{Carbon\Carbon::parse($nurse->dbs_details->issue_date)->format('d-m-Y')}}
                </p>
                @else
                <p>N/A</p>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <label class="h4"><b>Training Qualifications</b></label>
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Issue Date</th>
                            <th>Renewal Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($nurse->training as $training)
                        <tr>
                            <td>{{$training->compliance->name}}</td>
                            <td>{{Carbon\Carbon::parse($training->issue_date)->format('d-m-Y')}}</td>
                            <td>{{Carbon\Carbon::parse($training->renewal_date)->format('d-m-Y')}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
</body>

</html>