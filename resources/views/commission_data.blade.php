<div class="commission container my-4">
    <div class="row">
        <div class="col-md-12">
            <h1>
                عمولة حراج واحد
            </h1>

            <p>
                كما هو مذكور في معاهدة استخدام الموقع، فإن الموقع يحصل على عمولة قدرها 0.25% من سعر السلعة المباعة عن
                طريق الموقع و يدفعها المعلن، وهي أمانه في ذمته. إذا كانت السلعة المباعة سلعه عقاريه، وبها أكثر من
                وسيط، فإن الموقع يكون أحد الوسطاء، ويتقاسم العمولة معهم. ويعتبر هذا الشرط اتفاقاً ملزماً، يحق بموجبه
                للموقع المطالبة بهذه العمولة.
            </p>

            <hr>

            <h1>
                دفع العموله
            </h1>

            <p>
                يمكنك استخدام التحويل البنكي لدفع العموله عن طريق إرسال حواله إلى حساباتنا في البنوك المحليه.
            </p>
            {!! $bank_accounts->content !!}
            <hr>

            <div class="row">
                <div class="col-md-6">
                    <div class="col-sm-6">
                        <h4>
                            &nbsp;&nbsp;حساب قيمة العمولة :
                        </h4>
                    </div>
                    <div class="col-sm-6">
                        <input id="price" name="price" step="any" value="{{ old('price') }}"
                               type="number"
                               class="form-control" placeholder="ضع السعر هنا ..." required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-sm-6">
                        <h4>

                            &nbsp;&nbsp;عموله المتجر :
                        </h4>
                    </div>

                    <div class="col-sm-6">
                        <input id="commission" name="deal_commission" step="any"
                               value="{{ old('deal_commission') }}" type="number"
                               class="form-control" readonly="readonly">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
