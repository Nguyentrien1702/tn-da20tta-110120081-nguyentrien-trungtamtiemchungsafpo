<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trước tiêm chủng</title>
    <style>
        .italic-list li {
            font-style: italic;
        }
        #tuvantiemchung{
            background-color: blue !important;
        }
        #tuvantiemchung a{
            color: white !important;
        }
    </style>
</head>
<body>
@include("menu/header")
<link rel="stylesheet" href="{{ asset('css/khachhang/lichsu.css') }}">

<div id="chinhsachbaomat" class="content-body">
    <section class="body row">
        <section class="content_left col-md-9" >
            <div>
                <a href="">Tư vấn tiêm chủng</a>
                >
                <a href="{{ url('/Tu-van-tiem-chung/Truoc-khi-tiem') }}">Những điều cần biết trước khi chủng ngừa</a>
            </div>
            <section class="title">
                <hr>
                <h1>Những điều cần biết trước khi chủng ngừa</h1>
            </section>
            <div class="container mt-4">
                <h6><b>Mục lục:</b></h6>
                <ol class="italic-list">
                    <li><a href="#1">Vắc-xin hoạt động như thế nào?</a></li>
                    <li><a href="#2">Lợi ích và nguy cơ khi chủng ngừa Vắc-xin</a></li>
                    <li><a href="#3">Khám sàng lọc trước khi chủng ngừa</a></li>
                    <li><a href="#4">Những thông tin cần thông báo cho bác sĩ trước khi chủng ngừa</a></li>
                    <li><a href="#5">Hướng dẫn trước khi chủng ngừa</a></li>
                    <li><a href="#6">Các phản ứng có thể gặp phải sau khi chủng ngừa</a></li>
                    <li><a href="#7">Địa chỉ chủng ngừa phòng Vắc-xin uy tín</a></li>
                    <li><a href="#8">Một số câu hỏi thường gặp</a></li>
                </ol>
                <p>
                    Chủng ngừa là một vấn đề đã và đang được rất nhiều người quan tâm trong những năm trở lại đây, đặc biệt trong bối 
                    cảnh đại dịch COVID-19 đang hoành hành khắp Thế giới. Trong xã hội hiện đại, Vắc-xin và việc chủng ngừa không còn 
                    là vấn đề lạ lẫm đối với mọi người như trước đây. Chính vì vậy mà đa số trẻ em sau khi sinh ra đã có cơ hội được 
                    chủng ngừa nhờ đó phòng ngừa được rất nhiều bệnh.
                </p>
                <p>
                    Cũng nhờ có Vắc-xin trong các chương trình chủng ngừa mà những năm trở lại đây, tỷ lệ mắc các bệnh nguy hiểm tại 
                    nước ta đã giảm đáng kể, trong đó có nhiều bệnh truyền nhiễm nguy hiểm như bạch hầu, cúm,... Vậy việc chủng ngừa 
                    quan trọng như thế nào và trước khi chủng ngừa cần chuẩn bị và lưu ý những gì, chúng ta hãy cùng nhau tìm hiểu rõ 
                    hơn trong bài viết dưới đây nhé.
                </p>
                <h6 id="1">1. Vắc-xin hoạt động như thế nào?</h6>
                    <p>
                        Vắc-xin là một loại thuốc có bản chất là những kháng nguyên. Đây là phân tử có nguồn gốc từ các loại vi sinh vật, phân 
                        tử gây bệnh đã bị bất hoạt (làm chết) hoặc làm giảm độc lực, hoặc có thể là những loại phân tử có cấu trúc giống như vi 
                        sinh vật gây bệnh, vật chất di truyền do con người tạo ra. Khi chủng ngừa Vắc-xin, mục đích chính là đưa một lượng kháng 
                        nguyên vào cơ thể nhằm kích thích hệ thống miễn dịch, tạo ra lượng kháng thể, huấn luyện cơ thể để sẵn sàng chống lại sự 
                        tấn công của vi sinh vật gây bệnh. Có thể nói chủng ngừa vắc xin giống như bị nhiễm trùng nhưng không mắc bệnh.
                    </p>
                    <p>
                        Những người đã chủng ngừachủng ngừa ngừa Vắc-xin sẽ có miễn dịch chủ động. Khi những tác nhân đó tấn công cơ thể một lần 
                        nữa, hệ thống miễn dịch sẽ nhận biết và tạo ra kháng thể chống lại, bảo vệ cơ thể không bị lây nhiễm hay mắc bệnh.
                    </p>
                    <p>
                        Vắc-xin cơ bản được chia làm những loại như: Vắc-xin sống giảm động lực, Vắc-xin bất hoạt, Vắc xin tái tổ hợp, vắc xin độc 
                        tố, vắc xin vector, vắc xin AND hay mARN
                    </p>

                <h6 id="2">2. Lợi ích và nguy cơ khi chủng ngừa Vắc-xin</h6>
                    <p>
                        Vắc-xin được coi là một biện pháp rất hiệu quả trong công cuộc phòng tránh các loại bệnh truyền nhiễm. Việc chủng ngừa Vắc-xin 
                        giúp làm giảm đáng kể tỷ lệ mắc bệnh và tử vong do nhiều loại virus, vi khuẩn, từ đó giúp trẻ em khỏe mạnh hơn, phát triển thể 
                        chất và trí não một cách bình thường. Ngoài ra các chương trình chủng ngừa còn giúp bảo vệ sức khỏe cho cả người lớn khi chủng 
                        ngừa một số loại Vắc-xin như: Vắc-xin cúm, Vắc-xin não mô cầu, Vắc-xin viêm gan B, Vắc-xin HPV phòng bệnh ung thư cổ tử cung. 
                        Từ những lợi ích cụ thể thiết thực của việc chủng ngừa, Vắc-xin còn mang lại sự tác động lâu dài và bền vững cho từng cá nhân 
                        cũng như toàn cộng đồng.
                    </p>
                    <p>
                        Mặc dù Vắc-xin được coi là an toàn và có tác dụng phòng bệnh hiệu quả, nhưng không phải 100% người chủng ngừa Vắc-xin đều khỏe 
                        mạnh và phòng bệnh tốt. Đôi khi người ta vẫn gặp phải những phản ứng sau chủng ngừa và chính điều đó làm cho nhiều người lo ngại 
                        và phân vân có nên chủng ngừa Vắc-xin hay không, thậm chí cả việc chống vắc-xin (anti vaccine)?
                    </p>
                    <p>
                        Các phản ứng trong và sau khi chủng ngừa có thể có nhiều mức độ khác nhau, có thể bắt đầu từ những phản ứng nhẹ nhàng, thông thường 
                        không đáng lo cho đến những phản ứng nghiêm trọng hơn, một số trường hợp có thể đe dọa tính mạng của người chủng ngừa Vắc-xin. Hầu 
                        hết các trường hợp gặp phải phản ứng nặng nề sau khi chủng ngừa Vắc-xin là do cơ địa (dị ứng). Một số người gặp phải phản ứng sau 
                        chủng ngừa có thể do bản chất của Vắc-xin hoặc có vấn đề chất lượng. Do đó trước khi chủng ngừa bất cứ loại Vắc-xin nào, bạn cần 
                        phải được bác sĩ chủng ngừa thăm khám, khai thác tiền sử rõ ràng, kỹ lưỡng và theo dõi sau khi chủng ngừa.
                    </p>

                <h6 id="3">3. Khám sàng lọc trước khi chủng ngừa</h6>
                    <p>
                        Việc khám sàng lọc trước khi chủng ngừa được xem như một bước quan trọng không thể bỏ sót trước khi chủng ngừa bất cứ một loại Vắc-xin nào. 
                        Khám sàng lọc sẽ giúp phát hiện những bất thường của cơ thể, từ đó kiểm tra và xem xét người đó có đủ điều kiện để chủng ngừa Vắc-xin hay 
                        không. Việc này sẽ giúp hạn chế tối đa những phản ứng không mong muốn sau khi chủng ngừa.
                    </p>
                    <p>
                        Việc khám sàng lọc trước khi chủng ngừa sẽ bao gồm khai thác tiền sử bệnh tật từ trước tới nay, tuổi, chiều cao, cân nặng, các yếu tố bệnh 
                        tật kèm theo, các cán bộ y tế sẽ phải trực tiếp đo thân nhiệt, khám các cơ quan bộ phận trong cơ thể,... để đánh giá được tình hình chung 
                        cơ bản của mỗi cá nhân trước khi chủng ngừa. Từ việc khám và khai thác những yếu tố trên người ta sẽ xác định được những trường hợp sau:
                    </p>
                    <p>
                        Những trường hợp không được chủng ngừa Vắc-xin bao gồm:
                    </p>
                    <ul>
                        <li>
                            Các đối tượng có tiền sử shock hay những lần bị phản ứng quá mức nguy hiểm sau chủng ngừa Vắc-xin các lần trước đó. Các dấu hiệu có thể 
                            biểu hiện sau khi chủng ngừa là: sốt cao rét run, nhiệt độ tăng trên 39 độ hoặc thân nhiệt tăng giảm liên tục bất thường không ổn định, 
                            kèm theo trẻ có thể bị co giật hoặc biểu hiện các dấu hiệu tổn thương não, toàn thân tím tái, khó thở, suy hô hấp,...
                        </li>
                        <li>
                            Những đối tượng bị suy giảm hoặc thiểu năng chức năng các cơ quan bộ phận trong cơ thể như suy hô hấp, rối loạn tuần hoàn, suy tim, bệnh 
                            thận, mất hoặc giảm chức năng gan thận,…
                        </li>
                        <li>
                            Những đối tượng đang mắc phải các bệnh suy giảm hệ thống miễn dịch như HIV/AIDS, bệnh suy giảm miễn dịch bẩm sinh,... không nên lựa chọn 
                            các loại Vắc-xin sống giảm độc lực. Thay vào đó, người bệnh nên chọn chủng ngừa các loại Vắc-xin đã bị bất hoạt hoàn toàn cho an toàn.
                        </li>
                        <li>
                            Ngoài ra mỗi loại Vắc-xin sẽ có những chống chỉ định cụ thể khác, trước khi chủng ngừa các nhân viên y tế nên đọc kỹ và kiểm tra cẩn thận.
                        </li>
                    </ul>
                    <p>Những trường hợp hoãn chủng ngừa Vắc-xin bao gồm:</p>
                    <ul>
                        <li>
                            Các đối tượng đang mắc phải các bệnh lý có tính chất cấp tính, đặc biệt là các bệnh nhiễm trùng nặng đường hô hấp hay tiêu hóa, tiết niệu.
                        </li>
                        <li>
                            Những người đang bị sốt dù là nhẹ hay sốt cao hoặc những người đang bị hạ thân nhiệt dưới 35,5 độ cũng không được chủng ngừa Vắc-xin mà phải 
                            đợi đến khi cơ thể ổn định mới được chủng ngừa.
                        </li>
                        <li>
                            Những người mới hoặc đang sử dụng các các loại thuốc có bản chất là globulin miễn dịch trong vòng 3 tháng trở lại kể từ thời điểm chủng ngừa 
                            (trừ những trường hợp bệnh nhân đang sử dụng globulin miễn dịch để điều trị bệnh viêm gan B).
                        </li>
                        <li>
                            Những người đang hoặc mới hoàn thành quá trình điều trị bằng liệu pháp corticoid trong vòng nửa tháng trở lại.
                        </li>
                        <li>
                            Trẻ sơ sinh nhẹ cân cũng không nên chủng ngừa Vắc-xin ngay vì cơ thể trẻ đang còn yếu. Theo quy định, những trẻ có cân nặng dưới 2000g nên hoãn việc chủng ngừa Vắc-xin.
                        </li>
                        <li>
                            Mỗi loại Vắc-xin cũng sẽ có những chỉ định hoãn chủng ngừa đã được lưu ý rõ kèm theo thông tin của mỗi lọ thuốc. Trước khi chủng ngừa nhân viên 
                            y tế phải kiểm tra và đối chiếu kỹ.
                        </li>
                    </ul>

                <h6 id="4">4. Những thông tin cần thông báo cho bác sĩ trước khi chủng ngừa</h6>
                    <p>
                        Bất cứ đối tượng nào trước khi đi chủng ngừa cũng cần phải báo với bác sĩ sàng lọc những thông tin cơ bản để bác sĩ có thể nắm được tình hình của mỗi 
                        cá nhân trước khi chủng ngừa. Từ đó bệnh nhân mới được đánh giá xem có đủ điều kiện để chủng ngừa không, nếu trong quá trình chủng ngừa có vấn đề gì cũng có thể xử lý tốt hơn.
                    </p>
                    <p>
                        Đối với trẻ nhỏ: Cần cung cấp đủ các thông tin như: trẻ sinh đủ tháng hay thiếu tháng, cân nặng lúc sinh và hiện tại là bao nhiêu, trẻ có mắc bệnh gì 
                        không, những loại thuốc mà trẻ đã hoặc đang dùng, trẻ có dị ứng với thuốc hay loại thức ăn nào không. Nếu trẻ đã từng chủng ngừa Vắc-xin rồi thì những 
                        lần chủng ngừa trước có xảy ra dấu hiệu gì bất thường không, các loại Vắc-xin đã chủng ngừa gồm những loại nào,...
                    </p>
                    <p>
                        Đối với người lớn: Cần báo với bác sĩ những loại Vắc-xin đã chủng ngừa trước đây, những bệnh toàn thân mà bản thân mắc phải trước đó hoặc đang điều trị, 
                        tiền sử dị ứng, nhu cầu chủng ngừa Vắc-xin,...
                    </p>
                    <p>
                        Đối với phụ nữ có thai: Cung cấp đầy đủ các thông tin về thai kỳ như thai bao nhiêu tuần, kết quả kiểm tra của những lần khám thai trước có bình thường 
                        không, trước khi mang thai đã chủng ngừa loại Vắc-xin nào chưa. Các bác sĩ phải khai thác cả tiền sử về những lần mang thai trước đó. Thông thường trong 
                        quá trình mang thai, các bà bầu chỉ được chủng ngừa Vắc-xin cúm bất hoạt (ở bất kỳ thời điểm nào của thai kỳ) và Vắc-xin uốn ván vào những tháng giữa của 
                        thai kỳ để phòng bệnh uốn ván sơ sinh cho trẻ sau khi đẻ. Với những người mang thai 2 lần gần nhau thì các bà bầu cũng chỉ cần chủng ngừa một mũi Vắc-xin 
                        uốn ván, còn đối với những người mang thai lần đầu hoặc người mang thai hai lần cách xa nhau trên 5 năm thì bà bầu cần chủng ngừa 2 mũi uốn ván, mũi hai cách mũi một khoảng 1 tháng.
                    </p>

                <h6 id="5">5. Hướng dẫn trước khi chủng ngừa</h6>
                    <p>Đối với trẻ em:</p>
                    <ul>
                        <li>
                            Các bậc phụ huynh cần theo dõi xem vài ngày hoặc một tuần trở lại trẻ có bị sốt hay đang mắc phải bệnh cấp tính nào không. Nếu có thì nên tạm hoãn chưa 
                            cho trẻ đi chủng ngừa Vắc-xin mà phải điều trị ổn định địnhcho trẻ trước. Việc nâng cao sức khỏe và chăm sóc trẻ là một việc hết sức cần thiết và ý nghĩa trước khi cho trẻ đi chủng ngừa Vắc-xin.
                        </li>
                        <li>
                            Khi đưa trẻ đi chủng ngừa Vắc-xin, các bậc phụ huynh cũng cần phải mang đầy đủ giấy tờ, đặc biệt là sổ chủng ngừachủng ngừa của con đi để các bác sĩ có 
                            thể dựa vào đó để nắm rõ hơn về từng trường hợp, tránh chủng ngừa nhầm cho trẻ. Trước khi chủng ngừa trẻ cũng sẽ được kiểm tra nhiệt độ, cân nặng. Một 
                            điều cần lưu ý nữa mà nhiều bậc phụ huynh hay bỏ sót chính là phải đảm bảo vệ sinh cơ thể cho trẻ, điều này sẽ giúp cho trẻ tránh được tình trạng nhiễm trùng sau chủng ngừa.
                        </li>
                    </ul>
                    <p>Đối với người lớn:</p>
                    <ul>
                        <li>
                            Việc chủng ngừa đơn giản hơn do mỗi cá nhân đều có thể nắm rõ về tình trạng của bản thân để báo cáo cho bác sĩ. Những loại Vắc-xin chủng ngừa nhiều mũi cũng sẽ có phiếu chủng ngừa 
                            nên mọi người cần phải mang theo mỗi lần đi chủng ngừa. Mọi người chỉ đi chủng ngừa khi cơ thể khỏe mạnh.
                        </li>
                    </ul>

                <h6 id="6">6. Các phản ứng có thể gặp phải sau khi chủng ngừa</h6>
                    <p>
                        Như đã đề cập ở một số phần trên, một số trường hợp có thể gặp các phản ứng sau khi chủng ngừa Vắc-xin như:
                    </p>
                    <p>
                        Nhóm phản ứng nhẹ sau chủng ngừa bao gồm:
                    </p>
                    <ul>
                        <li>
                            Các phản ứng biểu hiện tại chỗ như đau, sưng tấy, nề đỏ tại nơi chủng ngừa hoặc vùng xung quanh nơi chủng ngừa.
                        </li>
                        <li>
                            Các phản ứng biểu hiện toàn thân như sốt nhẹ (37,5- 38 độ), gai rét, cảm giác trong người khó chịu, mệt mỏi đuối sức, đau mình mẩy, đau đầu, hoa mắt, chóng mặt, mất cảm giác 
                            ngon miệng, chán ăn, cảm giác cơ thể suy kiệt,...
                        </li>
                        <li>
                            Thông thường những phản ứng nhẹ sau chủng ngừa như trên sẽ chỉ xảy ra sau khi chủng ngừa Vắc-xin vài giờ cho tới 1 ngày là tối đa, sau đó các triệu chứng sẽ giảm dần rồi hết 
                            sau một khoảng thời gian ngắn. Đa số những trường hợp này sẽ ít khi gây nguy hiểm cho người chủng ngừa và cũng không cần sử dụng biện pháp can thiệp.
                        </li>
                    </ul>
                    <p>Nhóm phản ứng nặng sau chủng ngừa bao gồm:</p>
                    <ul>
                        <li>
                            Sốt cao, quấy khóc (trẻ nhỏ)
                        </li>
                        <li>
                            Dấu hiệu động kinh: đây được coi là một phản ứng quá mức gây hậu quả vĩnh viễn về sau cho người chủng ngừa. Động kinh có thể biểu hiện thoáng qua hoặc rõ ràng tùy từng trường hợp.
                        </li>
                        <li>
                            Giảm tiểu cầu: khi bị giảm tiểu cầu sẽ có thể dẫn tới các tình trạng như xuất huyết, máu khó đông, rối loạn đông cầm máu trong cơ thể,...
                        </li>
                        <li>
                            Các cơn giảm trương lực cơ hay giảm phản ứng của cơ thể.
                        </li>
                        <li>
                            Phản ứng phản vệ quá mức của cơ thể cũng có thể dẫn tới tình trạng shock đe dọa tới tính mạng người chủng ngừa.
                        </li>
                    </ul>
                    <p>
                        Hầu hết các phản ứng nặng sau khi sử dụng Vắc-xin kể trên sẽ ít khi để lại những hậu quả lâu dài nếu được theo dõi phát hiện sớm và xử trí kịp thời. Ngay cả phản ứng shock phản vệ tuy có 
                        thể đe dọa tính mạng của người chủng ngừa nhưng nếu được can thiệp sớm và đúng cách (đúng phác đồ chống shock quy định tại các phòng chủng ngừa) cũng sẽ không để lại di chứng về sau.
                    </p>

                <h6 id="7">7. Địa chỉ chủng ngừa phòng Vắc-xin uy tín</h6>
                    <p>
                        Tại Việt Nam hiện nay thì hầu hết các cơ sở chủng ngừa trên cả nước đều được trang bị và dự trữ đầy đủ các loại Vắc-xin cần thiết, đáp ứng được phần lớn nhu cầu về chủng ngừa Vắc-xin phòng 
                        bệnh cho người dân. Bất cứ ai khi có nhu cầu chủng ngừa phòng cho bản thân hoặc cho trẻ đề có thể đến các cơ sở chủng ngừa uy tín gần nhất để được tư vấn và tìm hiểu thêm những thông tin 
                        đầy đủ về chủng ngừa. Đặc biệt là đối với những gia đình có trẻ nhỏ thì lại càng phải lưu ý hơn về vấn đề này.
                    </p>
                    <p>
                        Trong những năm gần đây, hệ thống chủng ngừa Safpo đã và đang trở thành một trong những cơ sở chủng ngừa chủng ngừa hàng đầu của nước ta, lấy uy tín, chất lượng và sự hài lòng của khách hàng làm mục tiêu phát triển toàn hệ thống.
                    </p>
                    <p>
                        Tại hệ thống chủng ngừa Safpo hiện tại đang có đầy đủ các loại Vắc-xin phòng nhiều bệnh khác nhau như: thủy đậu, bạch hầu, uốn ván, ho gà, bại liệt, rota virus,cúm, viêm gan B,.... Khi 
                        đến với hệ thống chủng ngừa Safpo, quý khách hàng sẽ được tư vấn và khám sàng lọc kỹ càng trước khi chủng ngừa. Các hoạt động này luôn được thực hiện bởi đội ngũ các bác sĩ, chuyên gia y 
                        tế giàu kinh nghiệm, chuyên môn cao. Sau khi chủng ngừa mọi người cũng sẽ được theo dõi khoảng 30 phút để đảm bảo cho việc chủng ngừa an toàn và đạt hiệu quả cao nhất. Nếu có bất cứ phản 
                        ứng nào xảy ra sau chủng ngừa cũng sẽ được can thiệp kịp thời.
                    </p>
                    <p>
                        Quý khách có thể liên lạc hotline <b class="text-danger">1900 2071</b> hoặc nhắn tin vào Fanpage chính thức của Hệ thống chủng ngừa Safpo: Safpo – Hệ Thống Phòng Tiêm Xanh để được tư vấn bởi nhân viên của phòng tiêm 
                        chủng. Hoặc quý khách có thể tìm kiếm thông tin và địa chỉ phòng tiêm chủng Safpo tại link sau:
                    </p>
        
                <h6 id="8">8. Một số câu hỏi thường gặp</h6>
                    <ul>
                        <li>Sau khi chủng ngừa có nguy cơ mắc bệnh hay không?
                            <p>
                                Tuy Vắc-xin được coi như là một cách phòng bệnh hiệu quả nhất trong y tế nhưng không phải lúc nào hiệu quả phòng bệnh của Vắc-xin cũng đạt 100%. Do đó đôi khi chúng ta có thể gặp một số trường hợp mặc dù cơ 
                                thể đã được chủng ngừa một loại Vắc-xin nào đó nhưng sau đó vẫn có thể mắc bệnh bình thường. Những trường hợp này tuy mắc bệnh cũng không quá đáng lo vì bản chất trong cơ thể của người bệnh đó đã có một lượng 
                                kháng thể được sinh ra sau khi chủng ngừa Vắc-xin, sức đề kháng của họ sẽ cao hơn những người không chủng ngừa. Ở các đối tượng này, bệnh sẽ biểu hiện nhẹ nhàng hơn và dễ khỏi hơn.
                            </p>
                            <p>
                                Có thể giải thích tình trạng này là do lượng kháng thể trong cơ thể vẫn chưa đủ để chống lại lượng vi sinh vật gây bệnh tấn công. Tuy nhiên sau một lần mắc bệnh, cơ thể sẽ có thêm một lượng kháng thể đáng kể, 
                                cộng với lượng kháng thể mà cơ thể có được sau khi chủng ngừa Vắc-xin thì sẽ dễ đề kháng và phòng bệnh những lần sau.
                            </p>
                            <p>
                                Trên thực tế nhiều nghiên cứu cho thấy, tỷ lệ những người mắc bệnh sau khi đã chủng ngừa Vắc-xin là rất thấp, do vậy mà mọi người vẫn được khuyến khích nên chủng ngừa đầy đủ các loại Vắc-xin.
                            </p>
                        </li>

                        <li>Có nên ăn trước khi đi chủng ngừa không?
                            <p>
                                Đây là một câu hỏi tưởng như đơn giản nhưng thực chất lại được rất nhiều người quan tâm và thắc mắc. Đối với người lớn thì không cần quá quan tâm về vấn đề ăn uống trước khi đi chủng ngừa vì chỉ cần sức khỏe 
                                của họ ổn định là có thể chủng ngừa một cách an toàn. Nhưng đối với những đối tượng chủng ngừa là trẻ nhỏ thì cần lưu ý hơn về vấn đề ăn uống trước khi chủng ngừa.
                            </p>
                            <p>
                                Các bậc phụ huynh không nên để con mình đến chủng ngừa trong tình trạng quá đói hay quá khát, nên cho trẻ ăn uống bình thường trước khi chủng ngừa để đảm bảo trẻ đủ khỏe đủ điều kiện để chủng ngừa. Tuy nhiên 
                                cũng không nên để trẻ ăn uống hay bú quá no vì như vậy sẽ dễ làm cho trẻ buồn nôn và nôn trớ trong hoặc sau khi chủng ngừa.
                            </p>
                        </li>
                        <li>Trường hợp nào nên đến bệnh viện sau khi chủng ngừa?
                            <p>
                                Tất cả những trường hợp có phản ứng nặng sau khi chủng ngừa Vắc-xin đều cần phải đến bệnh viện hoặc cơ sở y tế gần nhất để kiểm tra lại tình trạng của trẻ. Nếu trẻ có những phản ứng quá mức cần phải can thiệp 
                                và điều trị ngay cho trẻ, tránh những biến chứng để lại về sau.
                            </p>
                            <p>
                                Ngoài ra đối với những trường hợp có phản ứng nhẹ sau chủng ngừa nhưng cá nhân người chủng ngừa lại có mắc các bệnh lý bẩm sinh hay bệnh lý nguy hiểm toàn thân khác thì tốt nhất cũng nên đến bệnh viện hay cơ 
                                sở y tế gần nhất để kiểm tra lại, tránh tình trạng bệnh nặng hơn sau chủng ngừa.
                            </p>
                            <p>
                                Trên đây là những thông tin về những điều cần biết trước khi chủng ngừa Vắc-xin, hy vọng với những thông tin cụ thể này, các bậc phụ huynh cũng như tất cả mọi người có thể hiểu rõ hơn về tầm quan trọng của Vắc-xin 
                                cũng như những điều cần lưu ý trước khi đi chủng ngừa. Chủng ngừa Vắc-xin không chỉ giúp bảo vệ được sức khỏe cho mỗi người mà từ đó có thể bảo vệ sức khỏe của cả cộng động. Mỗi chúng ta hãy cùng bảo vệ cộng đồng 
                                bằng chính việc thực hiện tham gia chủng ngừa Vắc-xin cho chính mình.
                            </p>
                        </li>
                    </ul>

            </div>

        </section>
        <section class="content_right col-md-3">
            @include("menu/hienthibaiviet")
        </section>
    </section>
</div>

@include("menu/footer")
</body>
</html>
