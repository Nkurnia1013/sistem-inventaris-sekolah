<!--   Core JS Files   -->
<script src="./mine/jquery-3.5.1.min.js" type="text/javascript"></script>
<script src="./mine/popper.min.js" type="text/javascript"></script>
<script src="./mine/bootstrap.min.js" type="text/javascript"></script>
<script src="./mine/wow.min.js"> </script>
<script src="./mine/datatables.min.js"> </script>
<script src="./mine/simplebar.min.js"> </script>
<script src="./mine/vue.js"> </script>
<script src="./mine/jQuery.print.js"> </script>
<script type="text/javascript">
$(function() {
    $('[data-toggle="tooltip"]').tooltip()
})
new WOW({
    animateClass: 'animate__animated', // default
}).init();
</script>
<script type="text/javascript">
var aneh;
$(document).ready(function() {
    aneh = $('.tb').DataTable({
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.childRowImmediate,
                type: 'column',
                renderer: function(api, rowIdx, columns) {
                    var data = $.map(columns, function(col, i) {
                        return col.hidden ?
                            '<li  class="list-group-item" data-dtr-index="1" data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
                            '<div class="d-flex justify-content-between" >' +

                            '<span class="dtr-title">' + col.title + ':' + '</span> ' +
                            '<span class="dtr-data text-break text-wrap">' + col.data + '</span>' +
                            '</li></div>' :
                            '';
                    }).join('');

                    return data ?
                        $('<ul style="display:block;" class="list-group dtr-details" />').append(data) :
                        false;
                }
            }
        },
        "dom": '<"p-2 d-flex justify-content-between" f>t<"card-body d-flex justify-content-end" p>',
        "lengthMenu": [
            [5, 10, -1],
            [5, 10, "All"]
        ],
        "language": {
            "paginate": {
                "previous": "<",
                "next": ">",
            }
        }
    });


});
</script>
<script type="text/javascript">
$(document).ready(function() {
    $(".dropdown-menu a.dropdown-toggle").on("click", function(o) {
        var s = $(this);
        s.toggleClass("active-dropdown");
        var n = $(this).offsetParent(".dropdown-menu");
        $(this).next().hasClass("show") || $(this).parents(".dropdown-menu").first().find(".show").removeClass("show");
        var e = $(this).next(".dropdown-menu");
        return e.toggleClass("show"), $(this).parent("li").toggleClass("show"), $(this).parents("li.nav-item.dropdown.show").on("hidden.bs.dropdown", function(o) { $(".dropdown-menu .show").removeClass("show"), s.removeClass("active-dropdown") }), n.parent().hasClass("navbar-nav") || s.next().css({ top: s[0].offsetTop, left: n.outerWidth() - 4 }), !1
    })
});
</script>
<script type="text/javascript">
function previewImage() {
    document.getElementById("image-preview").style.display = "block";
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("image-source").files[0]);

    oFReader.onload = function(oFREvent) {
        document.getElementById("image-preview").src = oFREvent.target.result;
    };
};

function previewImage2() {
    document.getElementById("image-preview2").style.display = "block";
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("image-source2").files[0]);

    oFReader.onload = function(oFREvent) {
        document.getElementById("image-preview2").src = oFREvent.target.result;
    };
};
</script>
<script type="text/javascript">
function barang(jenis,idbarang) {
    var kode = $('#'+ jenis +' option:selected').data('kode');
    $('#'+idbarang).val(kode);
    console.log(kode);
}
function barang2(barang,idbarang,nopabrik,image) {
    var kode = $('#'+ barang +' option:selected').data('barang');
    $('#'+idbarang).val(kode.idbarang);
    $('#'+nopabrik).val(kode.nopabrik);
        document.getElementById(image).src = 'upload/'+kode.foto;

}
    function onlyNumberKey(evt) {

        // Only ASCII charactar in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }
</script>
