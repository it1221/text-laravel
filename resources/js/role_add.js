$(function () {
    let add_buttons = $('[id^="add_role_"]');

    // const add_button = $('#add_role');
    // const val = $('#has_role').val();//delete_buttonのvalueを取り出す
    // const user_id = $('#has_role').data('user-id');

    add_buttons.on('click', function () {
        let $this = $(this);
        let role = $this.attr('id').substring(9); //delete_role_IDのIDだけ切り出す

        let user = $this.data('user-id');
        let delete_button = $(`#delete_role_${role}`);

        //csrf対策
        $.ajax( {
            headers: {
            'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
            },
            url: `/roles/${user}/attach`, //リクエストURL '/roles/{user}/detach'
            method: 'PUT', //形式
            dataType: 'json',
            data: { 
                'user' : user,
                'role_id' : role,
                '_method' : 'PUT'
            }
        })
            //成功時の処理
            .done(function(res)
            {
                //view側の削除したいHTML要素のidは「row_数字（ID）」とする
                $this.toggleClass('disabled');
                delete_button.toggleClass('disabled');
                // flashMessage( id, res[ "status" ], res[ "message" ] );
            } )
            //失敗時の処理
            .fail( function ( jqXHR, textStatus, errorThrown )
            {
                console.log( jqXHR );
                console.log( textStatus );
                console.log( errorThrown );
                // flashMessage( id, 'error', '削除に失敗しました。' );
            } );
        
    } );
    /**
     * 処理終了時にフラッシュメッセージを表示
     * @param {int} id
     * @param {str} status
     * @param {str} message
     */
    // function flashMessage ( id, status, message )
    // {
    //     let bgColor = 'bg-red-300';
    //     let dom = `<div id ="flash_${ id }" class="${ bgColor } w-1/2 mx-auto mb-4 p-2 text-white">
    //        ${ message }
    //     </div>`;
    //     if ( status == "error" )
    //     {
    //         $( ".container" ).append( dom );
    //     } else
    //     {
    //         bgColor = 'bg-blue-300';
    //         dom = `<div id ="flash_${ id }" class="${ bgColor } w-1/2 mx-auto mb-4 p-2 text-white">
    //        ${ message }
    //     </div>`;
    //         $( ".container" ).append( dom );
    //     }
    //     //2秒後に消す
    //     setTimeout( function ()
    //     {
    //         $( `#flash_${ id }` ).remove();
    //     }, 2000 );
    // }
} )