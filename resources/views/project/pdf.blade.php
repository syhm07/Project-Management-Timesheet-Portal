 <!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
      table {
        border-collapse: collapse;
        width: 100%;
      }
      td, th {
        border: solid 2px;
        padding: 10px 5px;
      }
      tr {
        text-align: center;
      }
      .container {
        width: 100%;
        text-align: center;
      }
    </style>
  </head>
  <body>
    <div class="container">
        <div><h2>List of  from {{$searchingVals['from']}} to {{$searchingVals['to']}}</h2></div>
       <table id="example2" role="grid">
            <thead>
              <tr role="row">
                <th width="10%">Category</th>
                <th width="10%">Project Code</th>
                <th width="10%">Client</th>
                <th width="15%">Project Manager</th>
                <th width="15%">Project Status</th>
                <th width="10%">Country</th>
                <th width="10%">Budget</th>
                <th width="10&">Start Date</th>
                <th width="10%">End Date</th>            
              </tr>
            </thead>
            <tbody>
            @foreach ($codes as $code)
                <tr role="row" class="odd">
                  <td>{{ $project[category_type] }}</td>
                  <td>{{ $project[p_code] }}</td>
                  <td>{{ $project[client] }}</td>
                  <td>{{ $project[project_manager] }}</td>
                  <td>{{ $project[project_status] }}</td>
                  <td>{{ $project[country_name] }}</td>
                  <td>{{ $project[budget] }}</td>
                  <td>{{ $project[start] }}</td>
                  <td>{{ $project[end]}}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
    </div>
  </body>
</html>