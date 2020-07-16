<footer class="main-footer">
    <div class="pull-right">
        <!-- Don't remove below text. It's violate the license. -->
        <strong>CloudSchool v{{$majorVersion}}.{{$minorVersion}}.{{$patchVersion}}-{{$suffixVersion}}</strong><span style="display: none;">{{substr($idc,0,7)}}</span> || Developed by <a class="cplink" href="{{$maintainer_url}}">{{$maintainer}}</a>
    </div>
    <strong>Copyright &copy; {{date('Y')}} <a href="#">@if(isset($appSettings['institute_settings']['name'])){{$appSettings['institute_settings']['name']}}@else CloudSchool @endif</a>.</strong> All rights
    reserved.
</footer>