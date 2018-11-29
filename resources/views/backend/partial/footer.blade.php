<footer class="main-footer">
    <div class="pull-right">
      <!-- Don't remove below text. Its againts copy right laws. -->
      <strong>School Management System Version 2.0 - {{substr($idc,0,7)}}</strong> || Developed by <a class="cplink" href="{{$maintainer_url}}">{{$maintainer}}</a>

    </div>
    <strong>Copyright &copy; {{date('Y')}} <a href="#">@if(isset($appSettings['institute_settings']['name'])){{$appSettings['institute_settings']['name']}}@else CloudSchool @endif</a>.</strong> All rights
    reserved.
  </footer>