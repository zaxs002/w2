$(document).ready(function() {

	//tables with drag sort
	
	var sort = $("#OXBFormSort  tbody");

	sort.sortable({
		handle : '',
		update : function () {

			var order = sort.sortable(
				'serialize',
				$('#forms.reorder.link').val()
			);

			$.ajax({
				url:$('#forms-reorder-link').val(),
				type:'post',
				data:order,
				success: function(msg){
					
				
				}
			});

		},
		create	: function() {
			sort.find("td").each(function() {
				var self = $(this);
				if (self.attr('width') == '') {
					self.attr('width', self.width() + 'px');
					self.css("cursor" , "move");
					//self.css('width', self.width() + 'px');
				}
			});
		}
	});

	sort.sortable({ axis: 'y' });	

	$("#OXBFormSort").disableSelection();


	//load more records
	var oxbLoadMore = $('#OXB-load-more');
	oxbLoadMore.find("a").click(function(){
		//$(this)
		//alert($(this).html());
		
		var oxbLoadMorePage = oxbLoadMore.find("input[name='ajax.load.more.page']")
		
		//increase the page number		
		var page = 	parseInt(oxbLoadMorePage.val()) + 1;
		oxbLoadMorePage.val(page);

		$.ajax({
			url: oxbLoadMore.find("input[name='ajax.load.more.url']").val()  + '&page=' + page,
			type:'post',
			data:"",
			success: function(msg){
				if (msg != "empty"){
					sort.append(msg); 

					//update the sizes for the new tables

					sort.find("td").each(function() {
						var self = $(this);
						if (self.attr('width') == '') {
							self.attr('width', self.width() + 'px');
							self.css("cursor" , "move");
							//self.css('width', self.width() + 'px');
						}
					});

				} else {
					//i have no more pages hide the load more
					$('.OXB-form-load-more').css("display",  "none");
					$('.FormPaging').css("display" , "none");

				}				
			}
		});

	});

});